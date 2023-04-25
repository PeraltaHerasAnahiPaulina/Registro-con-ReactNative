<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

//RUTAS PROTEGIDAS CON MIDDLEWARE
Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::get('user-profile',[AuthController::class,'userProfile']);
    Route::post('logout',[AuthController::class,'logout']);
});

//APP_URL=http://localhost
//APP_URL=http://192.168.1.5:8000