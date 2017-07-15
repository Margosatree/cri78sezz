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

Route::post('auth/register', 'Api\V1\UserController@register');
Route::post('auth/login', 'Api\V1\UserController@login');
Route::post('verifyuser', 'Api\V1\UserController@verifyUser');
Route::post('forgetpass', 'Api\V1\UserController@forgetPassword');
Route::post('resetpass/email', 'Api\V1\UserController@resetPassByEmail');
Route::post('resetpass/mobile', 'Api\V1\UserController@resetPassByMobile');



Route::post('create_role','Api\V1\Users\Acl\RoleControllerApi@addRole');
Route::post('modifiy_role','Api\V1\Users\Acl\RoleControllerApi@editRole');
Route::post('remove_role','Api\V1\Users\Acl\RoleControllerApi@deleteRole');
Route::get('list_role','Api\V1\Users\Acl\RoleControllerApi@listRole');

Route::post('assign_role','Api\V1\Users\Acl\RoleControllerApi@addRoleToUser');
Route::post('revoke_role','Api\V1\Users\Acl\RoleControllerApi@removeUserToRole');
Route::get('list_assign_role','Api\V1\Users\Acl\RoleControllerApi@listUserWithRole');


Route::post('create_perm','Api\V1\Users\Acl\PermissionControllerApi@addPerm');
Route::post('modifiy_perm','Api\V1\Users\Acl\PermissionControllerApi@editPerm');
Route::post('remove_perm','Api\V1\Users\Acl\PermissionControllerApi@deletePerm');
Route::get('list_perm','Api\V1\Users\Acl\PermissionControllerApi@listPerm');

Route::post('assign_perm','Api\V1\Users\Acl\PermissionControllerApi@addPermToUser');
Route::post('revoke_perm','Api\V1\Users\Acl\PermissionControllerApi@removePermToRole');
Route::get('list_assign_perm','Api\V1\Users\Acl\PermissionControllerApi@listRoleWithPerm');

Route::post('/User/updatestatus','Api\V1\UserController@activeUser');



Route::group(['middleware' => 'jwt.auth'], function () {
	//use for just retrive value via token
        Route::get('user', 'Api\V1\UserController@getAuthUser');
    //end

        Route::get('userinfo','Api\V1\UserController@getUserInfo');
        Route::post('userinfobyid','Api\V1\UserController@getUserInfoById');
        
        
	Route::post('/Match/list',          'Api\V1\CricketDetail\Match\MatchMastersControllerApi@listMatch');
	Route::post('/Match/add',           'Api\V1\CricketDetail\Match\MatchMastersControllerApi@addMatch');
	Route::post('/Match/update',        'Api\V1\CricketDetail\Match\MatchMastersControllerApi@updateMatch');
	Route::post('/Match/delete',        'Api\V1\CricketDetail\Match\MatchMastersControllerApi@deleteMatch');
	Route::get('/Match/mymatch',        'Api\V1\CricketDetail\Match\MatchMastersControllerApi@listMyMatch');

	Route::post('/Team/listTeamMembers',           'Api\V1\CricketDetail\Team\TeamMasterControllerApi@listTeam');
	Route::post('/Team/add',            'Api\V1\CricketDetail\Team\TeamMasterControllerApi@addTeam');
	Route::post('/Team/update',         'Api\V1\CricketDetail\Team\TeamMasterControllerApi@updateTeam');
	Route::post('/Team/delete',         'Api\V1\CricketDetail\Team\TeamMasterControllerApi@deleteTeam');

	Route::post('/teammember/list',           'Api\V1\CricketDetail\Team\TeamMembersControllerApi@listTeamMembers');
	Route::post('/teammember/add',            'Api\V1\CricketDetail\Team\TeamMembersControllerApi@addTeamMembers');
	Route::post('/teammember/update',         'Api\V1\CricketDetail\Team\TeamMembersControllerApi@updateTeamMembers');
	Route::post('/teammember/delete',         'Api\V1\CricketDetail\Team\TeamMembersControllerApi@deleteTeamMembers');
	Route::get('/teammember/myteam',         'Api\V1\CricketDetail\Team\TeamMembersControllerApi@listMyTeamMembers');

	Route::post('/TourMast/list',       'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@listTournament');
	Route::post('/TourMast/add',        'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@addTournament');
	Route::post('/TourMast/update',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@updateTournament');
	Route::post('/TourMast/delete',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@deleteTournament');
	Route::get('/TourMast/mytour',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@listMyTour');
        
	Route::post('/TourMast/utadd',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@addUserInTour');
	Route::post('/TourMast/utdelete',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@removeUserFromTour');
	Route::post('/TourMast/utlist',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@listUserWithTour');

	Route::post('/TourMast/utbulkadd',     'Api\V1\CricketDetail\Tournament\TournamentMasterControllerApi@addUserInTourBULK');

	Route::post('/TourDet/list','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@listTourDet');
	Route::post('/TourDet/add','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@addTourDet');
	Route::post('/TourDet/update','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@updateTourDet');
	Route::post('/TourDet/delete','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@deleteTourDet');
	Route::post('/TourDet/pendrules','Api\V1\CricketDetail\Tournament\TournamentDetailControllerApi@getTourPendRules');

	Route::post('/TourRule/list','Api\V1\CricketDetail\Tournament\TournamentRulesControllerApi@listRules');
        Route::post('/TourRule/add','Api\V1\CricketDetail\Tournament\TournamentRulesControllerApi@addRules');
        Route::post('/TourRule/update','Api\V1\CricketDetail\Tournament\TournamentRulesControllerApi@updateRules');
        Route::post('/TourRule/delete','Api\V1\CricketDetail\Tournament\TournamentRulesControllerApi@deleteRules');

	Route::post('/ChangePass/updateUser','Api\V1\Other\ChangePasswordControllerApi@updatePass');
	Route::post('/ChangePass/updateAdmin','Api\V1\Other\ChangePasswordControllerApi@adminUpdatePass');

	Route::post('/Org/list','Api\V1\Users\Org\OrganizationMasterControllerApi@listOrg');
	Route::post('/Org/add','Api\V1\Users\Org\OrganizationMasterControllerApi@addOrg');
	Route::post('/Org/update','Api\V1\Users\Org\OrganizationMasterControllerApi@updateOrg');
	Route::post('/Org/delete','Api\V1\Users\Org\OrganizationMasterControllerApi@deleteOrg');

	Route::get('/Org/mylist','Api\V1\Users\Org\OrganizationMasterControllerApi@listOrgById');
	Route::get('/Org/orguserlist','Api\V1\Users\Org\OrganizationMasterControllerApi@listUserByOrgId');
	Route::post('/Org/updateSpoc','Api\V1\Users\Org\OrganizationMasterControllerApi@updateSpoc');

	Route::post('/Achievement/list','Api\V1\Users\Player\UserAchievementControllerApi@listAchievement');
	Route::post('/Achievement/add','Api\V1\Users\Player\UserAchievementControllerApi@addAchievement');
        Route::post('/Achievement/update','Api\V1\Users\Player\UserAchievementControllerApi@updateAchievement');
	Route::post('/Achievement/delete','Api\V1\Users\Player\UserAchievementControllerApi@deleteAchievement');

	Route::post('/CriProfile/list','Api\V1\Users\Player\UserCricketProfileControllerApi@listCriProfile');
	Route::post('/CriProfile/add','Api\V1\Users\Player\UserCricketProfileControllerApi@addCriProfile');
	Route::post('/CriProfile/update','Api\V1\Users\Player\UserCricketProfileControllerApi@updateCriProfile');
	Route::post('/CriProfile/delete','Api\V1\Users\Player\UserCricketProfileControllerApi@deleteCriProfile');
	Route::post('/CriProfile/addImg','Api\V1\Users\Player\UserCricketProfileControllerApi@updateCriProImg');

	Route::post('/UserBio/list','Api\V1\Users\Player\UsersBioControllerApi@listUsersBio');
	Route::post('/UserBio/add','Api\V1\Users\Player\UsersBioControllerApi@addUsersBio');
	Route::post('/UserBio/addInfo','Api\V1\Users\Player\UsersBioControllerApi@addUsersBioInfo');
	Route::post('/UserBio/update','Api\V1\Users\Player\UsersBioControllerApi@updateUsersBio');
        
        Route::post('/User/bulk','Api\V1\Users\Player\UsersBulkControllerApi@upload');
        

	//Vrajesh API start

	Route::post('/store_scoreboard', 'ScoreboardController@store')->name('store_scoreboard');

	Route::post('/tickdata', 'Api\V1\CricketDetail\ScoreMaster@saveTick');
	Route::post('/getbowler', 'Api\V1\CricketDetail\ScoreMaster@getBowler');
	Route::post('/changebowler', 'Api\V1\CricketDetail\ScoreMaster@changeBowler');//wait

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

	//Vrajesh Api End
});
