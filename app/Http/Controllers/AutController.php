<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class AutController extends Controller
{
    // register a user
    public function register(Request $req){
        $fields =$req->validate([
            "fname" => "required",
            "othername" => "required",
            "email" => "required|email|unique:user_info,email",
            "password" => "required"
        ]);

        $user=User::create([
            'fname'=>$fields['fname'],
            'othername'=>$fields['othername'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password'])
        ]);

        $token=$user->createToken('myapptoken')->plainTextToken;

        $response=[
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);

    }
    //user or admin logout
    public function logout(){
        auth()->user()->tokens()->delete();
        
        return[
            'message'=>'Logout'
        ];
    }
    //user login
    public function login(Request $req){
        $fields =$req->validate([
            
            'email' =>'required|string|',
            'password' =>'required|string|'
        ]);

        $user=User::where('email',$fields['email'])->first();

        if(!$user || !hash::check($fields['password'],$user->password)){
            return response([
                'message'=>'failed !!'
            ],401);
        }
     

        $token=$user->createToken('myapptoken')->plainTextToken;

        $response=[
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
        
    }
    //admin login
    public function adminlogin(Request $req){
        $fields =$req->validate([
            
            'email' =>'required|string|',
            'password' =>'required|string|'
        ]);

        $admin=Admin::where('email',$fields['email'])->first();

        if(!$admin || !hash::check($fields['password'],$admin->password)){
            return response([
                'message'=>'failed !!'
            ],401);
        }
     

        $token=$admin->createToken('myapptoken')->plainTextToken;

        $response=[
            'user' => $admin,
            'token' => $token
        ];

        return response($response,201);

    }
}
