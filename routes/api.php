<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AutController;
use App\Http\Controllers\VerifyCartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Admin\Product;
use App\Http\Controllers\Admin\UploadController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// default api route for website
Route::get('homepage',[HomepageController::class,'homepage']);
Route::post('register',[AutController::class,'register']);
Route::post('login',[AutController::class,'login']);
Route::get('checkout',[VerifyCartController::class,'checkout']);
Route::post('checkStock',[VerifyCartController::class,'checkStock']);

// Route::get('stripe',[StripeController::class,'getSession']);




// login user api route
Route::group(['middleware' =>['auth:users']], function () {
    Route::get('userAddress',[UserController::class,'displayAddress']);
    Route::post('addAddress',[UserController::class,'addAddress']);
    Route::get('market',[StoreController::class,'store']);
    Route::post('logout',[AutController::class,'logout']);
});


 //ADMIN
//Admin login
Route::post('adminlogin',[AutController::class,'adminlogin']);
//login admin api route
Route::group(['middleware' =>['auth:admins']], function () {
Route::get('sold',[product::class,'productSold']);
Route::get('allproduct',[product::class,'allProduct']);
Route::get('topproduct',[product::class,'topProduct']);
Route::get('lowstock',[product::class,'lowStock']);
Route::get('totalsales',[product::class,'totalSales']);
Route::get('totalitem',[product::class,'totalItem']);
Route::get('totalcustomer',[product::class,'totalCustomer']);
Route::get('totalorder',[product::class,'totalOrder']);
Route::get('totalorderstatus',[product::class,'totalOrderStatus']);
Route::post('upload',[UploadController::class,'Upload']);
Route::post('logout',[AutController::class,'logout']);
});