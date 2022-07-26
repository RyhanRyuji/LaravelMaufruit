<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UploadProduct;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    // add new product name,description,unitMeasure and photo
    function Upload(Request $req){
        $addData=new UploadProduct;
        $addData->name=$req->input('name');
        $addData->description=$req->input('description');
        $addData->unitMeasure=$req->input('unitMeasure');


       
        if($req->hasFile('image')){
            $destination_path="http://localhost:8080/FullstackPratise/larBack/public/images/products/";
            $image=$req->File('image');
            $new_name=time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/images/products'),$new_name);
            $new_name=$destination_path.$new_name;
            // return response()->json('Successfully upload');
            $addData->imgPath=$new_name;

        }
        $addData->save();
        return 'Succesfully added';
        // else{
        //     return response()->json('image NULL');
        // }
    }
}
