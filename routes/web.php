<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('signup' , [

    'uses' => 'UsersController@postSignUp'
]);

Route::post('signin' , [

    'uses' => 'UsersController@postSignIn'
]);
Route::get('account' , [
    'uses' => 'UsersController@getAccount'
]);

Route::group(['middleware' => 'auth'], function () {


    Route::get('/dashboard', [
        'uses' => 'PostController@getDashboard',
        'as' => 'dashboard',
    ]);

    Route::post('save/account' , [
        'uses' => 'UsersController@postSaveAccount'
    ]);

    Route::get('/logout', [
        'uses' => 'UsersController@getLogOut',
    ]);
});

Route::get('/', [
    'uses'=>'HomeController@index',
    'as'=>'home'
]);





