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

Route::group(['middleware' => ['addTokenToHeader', 'auth:sanctum'], 'prefix' => '{user}'], function () {
    Route::post('email', 'App\Http\Controllers\EmailController@send')->name('email.send');
    Route::get('list', 'App\Http\Controllers\EmailController@list');
});

