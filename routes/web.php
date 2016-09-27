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

Route::group(['middleware' => ['web']], function () {
Route::get('/', 'LoginController@index');
Route::get('/login', 'LoginController@index');

Route::post('login-ajax-check', 'LoginController@ajax_check');

Route::get('logout', array('uses' => 'HomeController@doLogout'));

Route::get('product', array('uses' => 'HomeController@showProduct'));
Route::post('product/ajax-product', 'HomeController@ajaxshow');
//Dashboard
Route::group(['prefix' => 'admin'], function () {
    Route::get('dashboard/', 'DashboardController@index');
});


// User create,edit,list start

Route::group(['prefix' => 'admin'], function () {
    Route::get('user/', 'UserController@index');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('user/add', 'UserController@add');
});
Route::group(['prefix' => 'admin'], function () {
    Route::post('user/ajax-add', 'UserController@ajax_add');
});
Route::group(['prefix' => 'admin'], function () {
    Route::post('user/exist-email-check', 'UserController@exist_email_check');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('user/edit/{id}', 'UserController@edit');
});
Route::group(['prefix' => 'admin'], function () {
    Route::post('user/ajax-edit', 'UserController@ajax_edit');
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('user/exist-vcnumber-check', 'UserController@exist_vcnumber_check');
});
Route::group(['prefix' => 'admin'], function () {
    Route::post('user/change-users-active', 'UserController@change_users_active');
});
// User create,edit,list end

//Channel create,edit,list start
Route::group(['prefix' => 'admin'], function () {
    Route::get('channel/', 'ChannelController@index');
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('channel/change-channel-active', 'ChannelController@change_channel_active');
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('channel/add', 'ChannelController@add');
});
Route::group(['prefix' => 'admin'], function () {
    Route::post('channel/ajax-add', 'ChannelController@ajax_add');
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('channel/exist-channel-check', 'ChannelController@exist_channel_check');
});

});