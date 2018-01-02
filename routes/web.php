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
    return redirect('thread');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('thread', 'ThreadController@index');
Route::get('thread/create', 'ThreadController@create');
Route::post('thread', 'ThreadController@store')->middleware('email-not-confirmed');
Route::get('thread/search', 'SearchController@show');
Route::get('thread/{channel}', 'ThreadController@index');
Route::get('thread/{channel}/{thread}', 'ThreadController@show');
Route::patch('thread/{channel}/{thread}', 'ThreadController@update');
Route::delete('thread/{channel}/{thread}', 'ThreadController@destroy');

Route::get('thread/{channel}/{thread}/reply', 'ReplyController@index');
Route::post('thread/{channel}/{thread}/reply', 'ReplyController@store');

Route::post('thread/{channel}/{thread}/subscription', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('thread/{channel}/{thread}/subscription', 'ThreadSubscriptionController@destroy')->middleware('auth');

Route::post('locked-thread/{thread}', 'LockedThreadController@store')->name('locked-thread.store')->middleware('admin');
Route::delete('locked-thread/{thread}', 'LockedThreadController@destroy')->name('locked-thread.destroy')->middleware('admin');

Route::post('reply/{reply}/best', 'BestReplyController@store')->name('best-reply.store');
Route::delete('reply/{reply}', 'ReplyController@destroy')->name('reply.delete');
Route::patch('reply/{reply}', 'ReplyController@update');

Route::post('reply/{reply}/favorites', 'FavoriteController@store');
Route::delete('reply/{reply}/favorites', 'FavoriteController@destroy');

Route::get('profile/{user}', 'ProfileController@show')->name('profile');
Route::get('profile/{user}/subscription', 'UserNotificationController@index');
Route::delete('profile/{user}/subscription/{subscription}', 'UserNotificationController@destroy');

Route::get('register/confirm', 'RegisterConfirmationController@index');

Route::get('api/users', 'Api\UserController@index');
Route::post('api/user/{user}/avatar', 'Api\AvatarController@store')->middleware('auth')->name('avatar');
