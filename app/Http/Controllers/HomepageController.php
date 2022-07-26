<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    // all information to p display on homepage
    function homepage(){
      $productPopular=DB::table('total_sales')
                        ->orderBy('sales','desc')
                        ->limit(8)
                        ->get();

        $newProduct=DB::table('productsinfo')
                        ->orderBy('dateObtain','desc')
                        ->limit(8)
                        ->get();
                    

                    return response()->json([
                        "success" => true,
                        "data" =>[
                            "popularProduct" =>$productPopular,
                            "newProduct" => $newProduct
                        ]
                        ]);
                    
    }
}
