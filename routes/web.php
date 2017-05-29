<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth::routes();


// Replace by Auth::routes()
Route::get('/login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth\LoginController@login');
Route::post('/logout', 'Web\Auth\LoginController@logout')->name('logout');
Route::get('/home', 'Web\Other\HomeController@index')->name('home');

Route::get('/register', 'Web\Auth\RegisterController@showRegistrationForm')
			->name('register');
Route::post('/register', 'Web\Auth\RegisterController@register');
// till this Auth::routes()

//--Admin Login Start--//
Route::prefix('admin')->group(function(){
    Route::get('login', 'Web\Auth\LoginController@showAdminLoginForm')->name('admin.login');
    Route::post('login', 'Web\Auth\LoginController@adminLogin')->name('admin.login.submit');
    Route::get('home','Web\Users\Admin\AdminController@dashboard')->name('admin.dashboard');
});
//--Admin Login End--//

Route::Resource('/matchmaster','Web\CricketDetail\Match\MatchMastersController');

//--Start Verification Logic--//
Route::Resource('/verify','Web\Users\Player\UserVerifyController');
Route::get('/verifes/{token}/{otp}','Web\Users\Player\UserVerifyController@showVerify');
Route::post('/verifyguest','Web\Users\Player\UserVerifyController@storeGuest')->name('verifes.guest');
//--End Verification Logic--//

//--Start User Bio--//
Route::get('/userBio/createInfo','Web\Users\Player\UsersBioController@createInfo')
	   ->name('userBio.createInfo');
Route::post('/userBio/storeInfo','Web\Users\Player\UsersBioController@storeInfo')
	   ->name('userBio.storeInfo');
Route::get('/userBio/{userBio}/editInfo','Web\Users\Player\UsersBioController@editInfo')
	   ->name('userBio.editInfo');
Route::Resource('/userBio','Web\Users\Player\UsersBioController');
//--End User Bio--//

Route::get('/User/bulkUploadView','Web\Users\Player\UsersBulkController@bulkUploadView')
	   ->name('User.bulkUploadView');
Route::post('/User/bulkUpload','Web\Users\Player\UsersBulkController@bulkUpload')
	   ->name('User.bulkUpload');

Route::Resource('/org','Web\Users\Org\OrganizationMasterController');

Route::Resource('/criProfile','Web\Users\Player\UserCricketProfileController');

Route::get('/Profile/{id}','Web\Users\Player\UserProfileController@show')->name('profile.show');
Route::get('/ProfileUser/{id}','Web\Users\Player\UserProfileController@showUSer')->name('profile.showUser');

Route::Resource('/userAchieve','Web\Users\Player\UserAchievementController');

Route::Resource('/orgcriProfile','Web\Users\Org\OrgCricketController');

Route::Resource('/tourmst','Web\CricketDetail\Tournament\TournamentMasterController');

Route::Resource('/rule','Web\CricketDetail\Tournament\TournamentRulesController');

Route::Resource('/tour/{tour}/tourdet','Web\CricketDetail\Tournament\TournamentDetailController');

Route::Resource('/team','Web\CricketDetail\Team\TeamMasterController');

Route::Resource('/tour/{tour}/match','Web\CricketDetail\Match\MatchMastersController');

Route::get('/pass/request','Web\Other\ChangePasswordController@request')->name('pass.request');
Route::post('/pass/update','Web\Other\ChangePasswordController@update')->name('pass.update');
Route::get('/pass/{id}/adminrequest','Web\Other\ChangePasswordController@adminrequest')->name('pass.adminrequest');
Route::post('/pass/{id}/adminupdate','Web\Other\ChangePasswordController@adminupdate')->name('pass.adminupdate');

Route::get('/test', 'Web\test\HomeControllers@test');

//--Start Reset Password--//
Route::get('passwords/reset','Web\Auth\PassswordController@showResetForm')->name('password.show');
Route::post('passwords/email','Web\Auth\PassswordController@sendResetLinkEmail');
Route::get('passwords/reset/{token}','Web\Auth\PassswordController@showResetEmailForm');
Route::post('passwords/reset','Web\Auth\PassswordController@reset')->name('passwords.reset');
//For sms To Reset Password

Route::post('password/resetSms','Web\Auth\PassswordController@resetSms')->name('password.resetSms');
//--End of Reset Password--//

//--Start ACL Logic--//
Route::get('/adminhome', 'Web\Other\HomeController@display')->name('adminhome');
Route::get('/create_role', 'Web\Acl\RoleController@create')->name('create_role');
Route::post('/create_role', 'Web\Acl\RoleController@store');

Route::get('/assign_role', 'Web\Acl\RoleUserController@create')->name('assign_role');
Route::post('/assign_role', 'Web\Acl\RoleUserController@store');

Route::get('/revoke_role', 'Web\Acl\RoleUserController@displayRoles')->name('revoke_role');
Route::get('/revoke_role/{id}/{userId}', 'Web\Acl\RoleUserController@destroy')->name('revoke.role');

Route::get('/create_permission', 'Web\Acl\PermissionController@create')->name('create_permission');
Route::post('/create_permission', 'Web\Acl\PermissionController@store');

Route::get('/assign_permission', 'Web\Acl\PermissionRoleController@create')->name('assign_permission');
Route::post('/assign_permission', 'Web\Acl\PermissionRoleController@store');

Route::get('/revoke_permission', 'Web\Acl\PermissionRoleController@displayPermissions')->name('revoke_permission');
Route::get('/revoke_permission/{id}/{userId}', 'Web\Acl\PermissionRoleController@destroy')->name('revoke.permission');
//--End ACL Logic--//
