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

Route::post('/output', function(){
//    $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Tournament);
    $output = array('status' => 400 ,'msg' => 'Transection Fail');
//    $output = array('status' => 400 ,'msg' => 'Tournament Name Already Exist');
//    $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
    return response()->json($output);
});


//Route::post('/bio/addBio', 'Api\V1\Users\UsersBioControllerApi@addUserBio');





//Vrajeshbhai
// Route::post('/store_scoreboard', 'ScoreboardController@store')->name('store_scoreboard');

// Route::post('/tickdata', 'PostsController@saveTick');

// Route::post('/getbowler', 'PostsController@getBowler');
// Route::post('/changebowler', 'PostsController@changeBowler');

// Route::post('/getfielder', 'PostsController@getFielder');
// Route::post('/changefielder', 'PostsController@changeFielder');

// Route::post('/toursquad', 'PostsController@tourSquad');
// Route::post('/matchsquad', 'PostsController@matchSquad');
//Vrajeshbhai
//Route::post('/Match/list',          'Api\V1\CricketDetail\Match\MatchMastersControllerApi@listMatch');
Route::post('auth/register', 'Api\V1\UserController@register');
Route::post('auth/login', 'Api\V1\UserController@login');
Route::post('verifyuser', 'Api\V1\UserController@verifyUser');
Route::post('forgetpass', 'Api\V1\UserController@forgetPassword');
Route::post('resetpass/email', 'Api\V1\UserController@resetPassByEmail');
Route::post('resetpass/mobile', 'Api\V1\UserController@resetPassByMobile');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user', 'Api\V1\UserController@getAuthUser');
    
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

	Route::post('/TourDet/list','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@listTourDet');
	Route::post('/TourDet/add','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@addTourDet');
	Route::post('/TourDet/update','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@updateTourDet');
	Route::post('/TourDet/delete','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@deleteTourDet');

	Route::post('/TourRule/list','Api\V1\CricketDetail\Tournament\TournamentRulesControllerApi@listRules');
	Route::post('/TourRule/add','Api\V1\CricketDetail\Tournament\TournamentRulesControllerApi@addRules');

	Route::post('/ChangePass/updateUser','Api\V1\Other\ChangePasswordControllerApi@updatePass');
	Route::post('/ChangePass/updateAdmin','Api\V1\Other\ChangePasswordControllerApi@adminUpdatePass');

	Route::post('/Org/list','Api\V1\Users\Org\OrganizationMasterControllerApi@listOrg');
	Route::post('/Org/add','Api\V1\Users\Org\OrganizationMasterControllerApi@addOrg');
	Route::post('/Org/update','Api\V1\Users\Org\OrganizationMasterControllerApi@updateOrg');
	Route::post('/Org/delete','Api\V1\Users\Org\OrganizationMasterControllerApi@deleteOrg');

	Route::post('/Achievement/list','Api\V1\Users\Player\UserAchievementControllerApi@listAchievement');
	Route::post('/Achievement/add','Api\V1\Users\Player\UserAchievementControllerApi@addAchievement');
	Route::post('/Achievement/update','Api\V1\Users\Player\UserAchievementControllerApi@updateAchievement');
	Route::post('/Achievement/delete','Api\V1\Users\Player\UserAchievementControllerApi@deleteAchievement');

	Route::post('/CriProfile/list','Api\V1\Users\Player\UserCricketProfileControllerApi@listCriProfile');
	Route::post('/CriProfile/add','Api\V1\Users\Player\UserCricketProfileControllerApi@addCriProfile');
	Route::post('/CriProfile/update','Api\V1\Users\Player\UserCricketProfileControllerApi@updateCriProfile');
	Route::post('/CriProfile/delete','Api\V1\Users\Player\UserCricketProfileControllerApi@deleteCriProfile');

	Route::post('/UserBio/list','Api\V1\Users\Player\UsersBioController@listUsersBio');
	Route::post('/UserBio/add','Api\V1\Users\Player\UsersBioController@addUsersBio');
	Route::post('/UserBio/addInfo','Api\V1\Users\Player\UsersBioController@addUsersBioInfo');
	Route::post('/UserBio/update','Api\V1\Users\Player\UsersBioController@updateUsersBio');
});
Route::post('/store_scoreboard', 'ScoreboardController@store')->name('store_scoreboard');

Route::post('/tickdata', 'Api\V1\CricketDetail\ScoreMaster@saveTick');
Route::post('/getbowler', 'Api\V1\CricketDetail\ScoreMaster@getBowler');
Route::post('/changebowler', 'Api\V1\CricketDetail\ScoreMaster@changeBowler');

Route::post('/getfielder', 'Api\V1\CricketDetail\ScoreMaster@getFielder');
Route::post('/changefielder', 'Api\V1\CricketDetail\ScoreMaster@changeFielder');

Route::post('/toursquad', 'Api\V1\CricketDetail\ScoreMaster@tourSquad');
Route::post('/matchsquad', 'Api\V1\CricketDetail\ScoreMaster@matchSquad');

Route::post('/direct_batsman', 'Api\V1\CricketDetail\ScoreMaster@directBatsman');
Route::post('/direct_bowler', 'Api\V1\CricketDetail\ScoreMaster@directBowler');
Route::post('/direct_fielder', 'Api\V1\CricketDetail\ScoreMaster@directFielder');
Route::post('/direct_partnership', 'Api\V1\CricketDetail\ScoreMaster@directPartnership');
Route::post('/direct_score', 'Api\V1\CricketDetail\ScoreMaster@directScore');

Route::post('/history', 'Api\V1\CricketDetail\ScoreMaster@ballDataHistory');

Route::post('/undo', 'Api\V1\CricketDetail\ScoreMaster@ballDataUndo');