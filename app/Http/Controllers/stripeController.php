<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CheckoutController extends Controller {

    public function stripeCheckout($email, $cart, $discount, $shipping) {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SK'));

        $discounts = [];
        if ($discount !== 0) {
            $coupon = $stripe->coupons->create([
                "currency" => "MUR",
                "amount_off" => 5000,
                "duration" => 'once'
            ]);
            array_push($discount, $coupon->id);
        }

        $shipping_options = [];
        if($shipping>0) array_push($shipping_options, [
                            "shipping_rate_data" => [
                                "type" => 'fixed_amount',
                                "fixed_amount" => [
                                    "amount" => 150 * 100,
                                    "currency" => 'mur',
                                ],
                                "display_name" => 'MauFruits Delivery'
                            ]
                        ]);
                        
        $line_items = [];
        foreach($cart as $item) {
            array_push($line_items, [
                "price_data" => [
                    "currency" => "MUR",
                    "product_data" => [
                        "name" => $item["name"],
                        "images" => [$item["imgPath"]],
                    ],
                    "unit_amount" => $item["sellingPrice"] * 100,
                ],
                "quantity" => $item["qty"],
            ]);
        }

        $session = $stripe->checkout->sessions->create([
            "payment_method_types" => ["card"],
            "line_items" => $line_items,
            "mode" => "payment",
            "customer_email" => $email,
            "shipping_options" => $shipping_options,
            "discounts" => $discounts,
            "expires_at" => time() + 3600,
            "success_url" => env('CLIENT_URL').'/checkout-success',
            "cancel_url" => env('CLIENT_URL').'/checkout-fail',
        ]);

        return [
            "sessionUrl" => $session->url,
            "paymentId" => $session->payment_intent,
            "paymentStatus" => $session->payment_status
        ];
    }

    public function placeOrder(Request $request) {
        $deliveryOption = $request->deliveryOption;
        $totalPrice = $request->totalPrice;

        $shipping = 0;
        if($deliveryOption=='delivery') $shipping = 100;

        $numInStock =  DB::table('product')
                            ->where('id', 1)
                            ->get();

        return response()->json([
            "url" => env('CLIENT_URL'),
            "ans" => $numInStock[0],
            "deliveryOption" => $deliveryOption,
            "basketTotal" => $totalPrice,
            "shipping" => $shipping
        ]);
    }

    public function processPayment(Request $request) {
        $bearerToken = substr($request->header('authorization'), 7);
        $token = PersonalAccessToken::findToken($bearerToken);
        $userId = $token->tokenable->id;
        $deliveryOption = $request->deliveryOption;
        $address = $request->address;
        $paymentOption = $request->paymentOption;
        $email = $request->email;
        $cart = $request->cart;
        $totalPrice = $request->totalPrice;

        $res = DB::table('cart')->max('id');
        $cart_id = $res + 1;
        $cart_table_items = [];
        foreach($cart as $item) {
            $numInStock =  DB::table('product')
                            ->where('id', $item['id'])
                            ->get();

            DB::table('product')
              ->where('id', $item['id'])
              ->update(['numInStock' => 0]);

            array_push($cart_table_items, ["id" => $cart_id, "product_id" => $item['id'], "quantity" => $item['qty']]);  
        };

        DB::table('cart')->insert($cart_table_items);
        DB::table('order_details')->insertGetId([
            "orderStatus" => 'delivered',
            "totalPrice" => $totalPrice,
            "paymentType" => $paymentOption,
            "deliveryMethod" => $deliveryOption,
            "user_id" => $userId,
            "cart_id" => $cart_id,
            "address_id" => is_null($address) ? NULL : $address,
        ]);

        if ($paymentOption=='card') {
            $shippingCost = 0;
            if($deliveryOption=='delivery') $shippingCost = 150;
            $session = $this->stripeCheckout($email, $cart, 0, $shippingCost);

            return response()->json([
                "status" => true,   
                "sessionUrl" => $session['sessionUrl'] 
            ]);
        };
    
        return response()->json([
            "status" => true,
            "successUrl" => env('CLIENT_URL').'/checkout-success'
        ]);

    } 
}
