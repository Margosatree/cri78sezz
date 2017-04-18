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

Route::Resource('/verify','UserVerifyController');

Route::Resource('/userBio','UsersBioController');

Route::Resource('/org','OrganizationMasterController');

Route::Resource('/criProfile','UserCricketProfileController');

Route::prefix('admin')->group(function(){
    Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    //Route::get('/','AdminController@dashboard')->name('admin.dashboard');
});

Route::get('/admin','AdminController@dashboard')->name('admin.dashboard');
Route::get('/test', 'HomeController@test');
