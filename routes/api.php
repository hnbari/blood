<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonateSchedualController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
// Route::apiResource('donate',DonateSchedualController::class)->middleware('auth');
Route::controller(DonateSchedualController::class)->middleware('auth')-> group(function(){
    Route::post('donate','store');
    Route::get('donate','index');
    Route::get('donate/{user_id}','show');
    Route::post('donate/{user_id}','update');
    Route::get('/log',[DonateSchedualController::class,'log']);
});