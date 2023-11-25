<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//userController..
Route::Post('user/add_user', 'App\Http\Controllers\UserController@CreateUsers');
Route::Post('user/login_user', 'App\Http\Controllers\UserController@loginAccount');
Route::Post('user/send_otp', 'App\Http\Controllers\UserController@forgotPassword');

//home_screen
Route::get('dress/home_screen','App\Http\Controllers\DressController@homeScreen');
//best_sellers 
Route::get('dress/best_sellers','App\Http\Controllers\DressController@newBestsSellers');
//new_arrival
Route::get('dress/new_arrival','App\Http\Controllers\DressController@newArrival');


