<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Productsinfo;




class VerifyCartController extends Controller
{
    //check whether there is enough stock for user 
    function checkStock(Request $req){
        $id=$req->input('id');
        $name=$req->input('name');
        $quantity=$req->input('quantity');


        $amount=DB::table('productsinfo')
        ->where('product_id',$id)
        ->pluck('numInStock');

            if( $amount[0]<$quantity){
                return response()->json([
                    "message"=>"Not enough stock",
                    "Number available" =>$amount[0]
                    ]
                );
            }
            else{
                return response()->json([
                    "message"=>"Available",
                    "Number available" =>$quantity,      
                    ]
                );
            }
    }
     
}
