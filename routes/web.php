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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/password/check', 'Auth\ForgetMiddleController@checkData')
		->name('password.check');
		
Route::Resource('/verify','UserVerifyController');

Route::get('/verifes/{token}/{otp}','UserVerifyController@showVerify');

Route::post('/verifyguest','UserVerifyController@storeGuest')->name('verifes.guest');

Route::get('/userBio/createInfo','UsersBioController@createInfo')
	   ->name('userBio.createInfo');

Route::post('/userBio/storeInfo','UsersBioController@storeInfo')
	   ->name('userBio.storeInfo');

Route::get('/userBio/{userBio}/editInfo','UsersBioController@editInfo')
	   ->name('userBio.editInfo');

Route::Resource('/userBio','UsersBioController');

Route::get('/User/bulkUploadView','UsersBulkController@bulkUploadView')
	   ->name('User.bulkUploadView');
Route::post('/User/bulkUpload','UsersBulkController@bulkUpload')
	   ->name('User.bulkUpload');

Route::Resource('/org','OrganizationMasterController');

Route::Resource('/criProfile','UserCricketProfileController');

Route::Resource('/Profile','UserProfileController');

Route::Resource('/userAchieve','UserAchievementController');

Route::Resource('/orgcriProfile','OrgCricketController');

Route::Resource('/tourmst','TournamentMasterController');

Route::Resource('/rule','TournamentRulesController');

Route::Resource('/tour/{tour}/tourdet','TournamentDetailController');

Route::Resource('/team','TeamMasterController');

Route::Resource('/tour/{tour}/match','MatchMastersController');

Route::get('/pass/request','ChangePasswordController@request')->name('pass.request');
Route::post('/pass/update','ChangePasswordController@update')->name('pass.update');
Route::get('/pass/{id}/adminrequest','ChangePasswordController@adminrequest')->name('pass.adminrequest');
Route::post('/pass/{id}/adminupdate','ChangePasswordController@adminupdate')->name('pass.adminupdate');

Route::prefix('admin')->group(function(){
    Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    //Route::get('/','AdminController@dashboard')->name('admin.dashboard');
});


Route::get('/admin','AdminController@dashboard')->name('admin.dashboard');
Route::get('/test', 'HomeController@test');

//For Reset Password

Route::get('passwords/reset','Auth\PassswordController@showResetForm')->name('password.show');
Route::post('passwords/email','Auth\PassswordController@sendResetLinkEmail');

Route::get('passwords/reset/{token}','Auth\PassswordController@showResetEmailForm');

Route::post('passwords/reset','Auth\PassswordController@reset')->name('passwords.reset');
//For sms To Reset Password

Route::post('password/resetSms','Auth\PassswordController@resetSms')
	  ->name('password.resetSms');

//End of Reset Password
