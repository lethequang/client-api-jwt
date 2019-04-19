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
Route::get('/', 'CommonController@getLogin');

Route::get('/login', 'CommonController@getlogin');
Route::post('/login', [
	'uses' => 'CommonController@postLogin',
	'as' => 'login'
]);

Route::group(['middleware' => 'auth-api'], function () {

	Route::get('home', [
		'uses' => 'CommonController@getHome',
		'as' => 'getHome'
	]);

	Route::get('profile', [
		'uses' => 'CommonController@getProfile',
		'as' => 'getProfile'
	]);

	Route::get('/logout', [
		'uses' => 'CommonController@logout',
		'as' => 'logout'
	]);

	Route::group(['prefix' => 'user'], function (){
		Route::get('show-all', [
			'uses' => 'CommonController@showAll',
			'as' => 'user.show-all'
		]);
	});

});