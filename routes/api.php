<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
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


Route::get('/test', function(){
    return response(['message' => 'Test Data!']);
});

Route::group(['prefix' => 'auth'], function () {

    //Auth routes starts

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/authenticated-user', [AuthController::class, 'userProfile']);

    Route::get('/unauthenticated-user', function(){
        return response(['message' => 'Unauthenticated!'], 401);
    })->name('unauthenticated');
    
    //Auth routes end\

});


Route::middleware('auth:api')->get('/authorized-user', function (Request $request) {
    return $request->user();
});

// Resouce Controller for Product
// Middleware added in controller

Route::apiResource('products', ProductController::class);