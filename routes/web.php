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
Route::get('/', 'AuthController@getLogin');

Route::get('/login', 'AuthController@getlogin');
Route::post('/login', [
	'uses' => 'AuthController@postLogin',
	'as' => 'login'
]);

Route::group(['middleware' => 'auth-api'], function () {

	Route::get('home', [
		'uses' => 'AuthController@getHome',
		'as' => 'getHome'
	]);

	Route::get('profile', [
		'uses' => 'AuthController@getProfile',
		'as' => 'getProfile'
	]);

	Route::get('/logout', [
		'uses' => 'AuthController@logout',
		'as' => 'logout'
	]);

	Route::group(['prefix' => 'user'], function (){
		Route::get('show-all', [
			'uses' => 'UserController@showAll',
			'as' => 'user.show-all'
		]);
		Route::get('ajax-data', [
			'uses' => 'UserController@ajaxData',
			'as' => 'user.ajax-data'
		]);
		Route::post('delete/{id}', [
			'uses' => 'UserController@destroy',
			'as' => 'user.delete'
		]);
		Route::get('/create', [
			'uses' => 'UserController@create',
			'as' => 'user.create'
		]);
		Route::post('/create',[
			'uses' => 'UserController@store',
			'as' => 'user.store'
		]);
		Route::get('/edit/{id}',[
			'uses' => 'UserController@edit',
			'as' => 'user.edit'
		]);
		Route::post('/edit/{id}',[
			'uses' => 'UserController@update',
			'as' => 'user.update'
		]);
	});

});