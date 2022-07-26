<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class Product extends Controller
{
    //  get all products that have been sold
    function productSold(){
        $values=DB::table('total_sales')
        ->select('name','grade','numInStock','sales') 
        ->get();
            return response()->json([
                "data" =>$values
                ]);
    }
    // get all products stocks,name,grade
    function allProduct(){
        $values=DB::table('productsinfo')
        ->select('name','grade','numInStock','dateObtain') 
        ->get();

        return response()->json([
            "data" =>$values
            ]);

    }
    //product that are mostly sold
    function topProduct(){
        $values=DB::table('total_sales')
        ->select('name','grade','numInStock','sales') 
        ->orderBy('sales', 'desc')
        ->get();

        return response()->json([
            "data" =>$values
            ]);

    }
    //product that are running out of stock
    function lowStock(){
        $values=DB::table('productsinfo')
        ->select('name','grade','numInStock','dateObtain')
        ->orderBy('numInStock', 'asc') 
        ->get();

        return response()->json([
            "data" =>$values
            ]);
    }
    // how many money get from fruits sold
    function totalSales(){

        $values=DB::table('order_details')
        ->sum('totalPrice');

        return response()->json([
            "data" =>$values
            ]);
    }
    //total number of products sold
    function totalItem(){

        $values=DB::table('total_sales')
        ->sum('sales'); 

        return response()->json([
            "data" =>$values
            ]);
    }
    // count all customer
    function totalCustomer(){

        $values=DB::table('cart')
        ->groupBY('user_id')
        ->sum('user_id'); 

        return response()->json([
            "data" =>$values
            ]);
    }
    // amount of order obtain
    function totalOrder(){

        $values=DB::table('order_details')
        ->count('id'); 

        return response()->json([
            "data" =>$values
            ]);
    }
    // getting the total number of pending and deliver order
    function totalOrderStatus(){

        $deliver=DB::table('order_details')
        ->where('orderStatus','=','delivered')
        ->count('id'); 

        $pending=DB::table('order_details')
        ->where('orderStatus','=','pending')
        ->count('id'); 


        return response()->json([
            "data" =>[
                "Deliverer" =>$deliver,
                "pending" => $pending
            ]
            ]);
    }

}
