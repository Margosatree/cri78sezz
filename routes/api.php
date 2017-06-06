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

Route::post('/bio/addBio', 'Api\V1\Users\UsersBioControllerApi@addUserBio');



Route::post('/tourmast/listTournament', 'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@listTournament');
Route::post('/tourmast/addTournament', 'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@addTournament');
Route::post('/tourmast/updateTournament', 'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@updateTournament');
Route::post('/tourmast/deleteTournament', 'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@deleteTournament');