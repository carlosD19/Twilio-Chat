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
    return view('security/login');
});

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::get('logout', 'UserController@logout');

Route::resource('channels', 'ChannelController');


Route::get('chats/message/{channel}', 'ChatController@message');
Route::get('chats/member/{channel}', 'ChatController@member');


Route::get('chats', 'ChatController@index');
Route::post('chats', 'ChatController@sendMessage')->name('chats.send');
Route::get('chats/{channel}', 'ChatController@channel')->name('chats.channel');
Route::get('chats/join/{channel}', 'ChatController@join')->name('chats.join');
