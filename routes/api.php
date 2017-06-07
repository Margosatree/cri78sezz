<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('auth/register', 'Api\V1\UserController@register');
Route::post('auth/login', 'Api\V1\UserController@login');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user', 'Api\V1\UserController@getAuthUser');
});