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

Route::post('/Match/list',          'Api\V1\CricketDetail\Match\MatchMastersControllerApi@listMatch');
Route::post('/Match/add',           'Api\V1\CricketDetail\Match\MatchMastersControllerApi@addMatch');
Route::post('/Match/update',        'Api\V1\CricketDetail\Match\MatchMastersControllerApi@updateMatch');
Route::post('/Match/delete',        'Api\V1\CricketDetail\Match\MatchMastersControllerApi@deleteMatch');

Route::post('/Team/list',           'Api\V1\CricketDetail\Team\TeamMasterControllerApi@listTeam');
Route::post('/Team/add',            'Api\V1\CricketDetail\Team\TeamMasterControllerApi@addTeam');
Route::post('/Team/update',         'Api\V1\CricketDetail\Team\TeamMasterControllerApi@updateTeam');
Route::post('/Team/delete',         'Api\V1\CricketDetail\Team\TeamMasterControllerApi@deleteTeam');

Route::post('/TourMast/list',       'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@listTournament');
Route::post('/TourMast/add',        'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@addTournament');
Route::post('/TourMast/update',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@updateTournament');
Route::post('/TourMast/delete',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@deleteTournament');

Route::post('/TourDet/list',        'Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@listTourDet');
Route::post('/TourDet/add',         'Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@addTourDet');
Route::post('/TourDet/update',      'Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@updateTourDet');
Route::post('/TourDet/delete',      'Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@deleteTourDet');

Route::post('/TourRule/list',       'Api\V1\CricketDetail\Tournament\TournamentRulesControllerApi@listRules');
Route::post('/TourRule/add',        'Api\V1\CricketDetail\Tournament\TournamentRulesControllerApi@addRules');

Route::post('/ChangePass/updateUser',   'Api\V1\Other\ChangePasswordController@updatePass');
Route::post('/ChangePass/updateAdmin',  'Api\V1\Other\ChangePasswordController@adminUpdatePass');

Route::post('/Org/list',       'Api\V1\Users\Org\OrganizationMasterControllerApi@listOrg');
Route::post('/Org/add',        'Api\V1\Users\Org\OrganizationMasterControllerApi@addOrg');
Route::post('/Org/update',     'Api\V1\Users\Org\OrganizationMasterControllerApi@updateOrg');
Route::post('/Org/delete',     'Api\V1\Users\Org\OrganizationMasterControllerApi@deleteOrg');

Route::post('/Org/list',       'Api\V1\Users\Player\UserAchievementControllerApi@listAchievement');
Route::post('/Org/add',        'Api\V1\Users\Player\UserAchievementControllerApi@addAchievement');
Route::post('/Org/update',     'Api\V1\Users\Player\UserAchievementControllerApi@updateAchievement');
Route::post('/Org/delete',     'Api\V1\Users\Player\UserAchievementControllerApi@deleteAchievement');

Route::post('/CriProfile/list',       'Api\V1\Users\Player\UserCricketProfileControllerApi@listCriProfile');
Route::post('/CriProfile/add',        'Api\V1\Users\Player\UserCricketProfileControllerApi@addCriProfile');
Route::post('/CriProfile/update',     'Api\V1\Users\Player\UserCricketProfileControllerApi@updateCriProfile');
Route::post('/CriProfile/delete',     'Api\V1\Users\Player\UserCricketProfileControllerApi@deleteCriProfile');

