<?php

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


Route::get('/Subject/{subject}','App\Http\Controllers\SubjectController@show');
Route::put('/Subject/{subject}','App\Http\Controllers\SubjectController@update');
Route::post('/Subject','App\Http\Controllers\SubjectController@store');
Route::delete('/Subject/{subject}','App\Http\Controllers\SubjectController@destroy');
