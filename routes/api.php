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
Route::post('/store_scoreboard', 'ScoreboardController@store')->name('store_scoreboard');

Route::post('/tickdata', 'PostsController@saveTick');
Route::post('/getbowler', 'PostsController@getBowler');
Route::post('/changebowler', 'PostsController@changeBowler');

Route::post('/getfielder', 'PostsController@getFielder');
Route::post('/changefielder', 'PostsController@changeFielder');

Route::post('/toursquad', 'PostsController@tourSquad');
Route::post('/matchsquad', 'PostsController@matchSquad');