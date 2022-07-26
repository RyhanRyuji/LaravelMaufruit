<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    // store page where user search product accordingly
    function store(Request $request){
       $search=$request->query('search');  
       $category=$request->query('category');
       $price=$request->query('price');
       $grade=$request->query('grade');

    
        $result=DB::table('productsinfo');

       if(!is_null($search)){
             $result=$result->where("name",$search);         
       }
       if(!is_null($category)){
       if($category=='popular'){
        $result=DB::table('total_sales')
            ->orderBy('sales','desc');
            }
        if($category=='new'){
            $result=$result-> orderBy('dateObtain','desc');
        }
        }
       if(!is_null($price)){
        $result=$result->orderBy('sellingPrice',$price);
       }

       if(!is_null($grade)){
        $result=$result->whereIn("grade",explode(",",$grade));
       }

            $result=$result->get();
        
                        return response()->json([
                            "query" => $search,
                            "success" => true,
                            "data" =>$result
                        ]);


    }
}
