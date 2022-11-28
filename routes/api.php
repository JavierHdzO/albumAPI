<?php

use App\Http\Controllers\authController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use \App\Http\Middleware\checkKey;

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
Route::middleware(checkKey::class)->group(function(){
    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::get('userAlbum/{user}', [UserController::class, 'getAlbums']);
    Route::get('userAlbum/{album}/{user}', [UserController::class, 'getAlbum']);
    Route::get('authentication/logout', [authController::class, 'logout']);
});

Route::post('authentication/register',[authController::class, 'store']);
Route::post('authentication/login', [authController::class, 'login']);

Route::apiResource('photos', '\App\Http\Controllers\PhotoController');