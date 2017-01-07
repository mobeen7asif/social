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

//Route::get('/', function () {
//    return view('welcome');
//});

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

    Route::post('create/post' , [
        'uses' => 'PostController@postCreatePost'
    ]);

    Route::get('/posts', [
        'uses' => 'PostController@getAllPosts',
    ]);

    Route::get('/delete/{postId}' , [
        'uses' => 'PostController@postDeletePost'
    ]);

    Route::get('person/timeline/{user_id}', [

        'uses' => 'PostController@getPersonTimeline'
    ]);


});

Route::get('/', [
    'uses'=>'HomeController@index',
    'as'=>'home'
]);




Route::post('like/{post_id}' , [
    'uses' => 'PostController@like'
]);


Route::post('Dislike/{post_id}' , [
    'uses' => 'PostController@disLike'
]);

Route::post('update/{postId}' , [
    'uses' => 'PostController@postUpdatePost'
]);

Route::post('comment/{postId}' , [
    'uses' => 'CommentsController@postComment'
]);


Route::get('other/likes/{postId}' , [
    'uses' => 'PostController@getLikes'
]);









