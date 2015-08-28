<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('/home', ['as' => 'home', 'uses' =>  'HomeController@index']);
Route::get('/upload-csv', ['as' => 'upload-csv', 'uses' => 'CsvController@getUpload']);
Route::post('/upload-csv', 'CsvController@postUpload');
Route::get('/algemene-informatie', 'GeneralController@getIndex');
Route::get('/studentdashboard', 'StudentdashboardController@getIndex');
Route::get('/fireweekoverview', 'WeekoverviewController@fire');
Route::get('/createstudents', 'DashboardController@createStudents');
Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@getIndex']);
Route::post('/profile', 'ProfileController@postUpdate');
Route::post('/login', 'HomeController@doLogin');
Route::get('/register', 'RegisterController@getIndex');
Route::post('/register', 'RegisterController@register');
Route::get('/dashboard-history', 'HistoryController@getIndex');
Route::get('/students', 'StudentController@getIndex');
Route::get('/dashboard-versturen', 'DashboardController@versturenAction');
Route::get('/createdashboards', 'DashboardController@createweekoverviews');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	'dashboard' => 'DashboardController',
]);