<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{
    // display the the user address
    function displayAddress(){
        $id=Auth::user()->id;
            $address=DB::table('usercontact_info')
                        ->where('user_id',$id)
                        ->get();

                    return response()->json([
                        "success" => true,
                        "data" =>$address
                        ]);
    }
        //user add user address
        function addAddress(Request $req){
        
                    $addData=new UserAddress;
                    $addData->addressLine=$req->input('address');
                    $addData->city=$req->input('city');
                    $addData->contactNumber=$req->input('phone');
                    $addData->user_id=Auth::user()->id;
                    $addData->save();

                    return 'Succesfully added';
        }
}
