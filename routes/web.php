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

Route::resource('thread', 'ThreadController', ['except' => ['show']]);
Route::get('thread/{channel}', 'ThreadController@index');
Route::get('thread/{channel}/{thread}', 'ThreadController@show');

Route::post('thread/{channel}/{thread}/reply', 'ReplyController@store');

Route::post('reply/{reply}/favorites', 'FavoriteController@store');
