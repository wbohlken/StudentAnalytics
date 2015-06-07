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
Route::post('/upload-csv', ['as' => 'post-csv', 'uses' => 'HomeController@upload']);
Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);
Route::post('/profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);
Route::post('/login', array('uses' => 'HomeController@doLogin'));
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
