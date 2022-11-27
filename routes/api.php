<?php

use App\Http\Controllers\authController;
use GuzzleHttp\Middleware;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//protected routes
Route::resource('user', \App\Http\Controllers\UserController::class)->middleware('checkKey');

//need to fix auth on logout
Route::get('authentication/logout', [authController::class, 'logout']);
Route::post('authentication/login', [authController::class, 'login']);
Route::resource('authentication',\App\Http\Controllers\authController::class)->only(['store', 'login', 'logout']);