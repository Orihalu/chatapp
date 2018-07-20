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

Route::get('/rooms', 'RoomController@index');
Route::post('/rooms', 'RoomController@search');

Route::get('/room/{id}', 'RoomController@show')->where('id','[0-9]+');
Route::get('/room/create', 'RoomController@create');
Route::post('/room/store', 'RoomController@store');
Route::delete('/room/{id}', 'CommentController@destroy');


Route::post('/room/{id}/join','UserController@join');
Route::post('/room/{id}/leave', 'UserController@leave');

Route::post('/users','UserController@search');

Route::post('/room/{id}','CommentController@store');

Route::get('/users/{user}', 'UserController@show')->where('id','[0-9]+');
Route::get('/users', 'UserController@index');
Route::post('/users/{user}/follow', 'UserController@follow');
Route::post('/users/{user}/unfollow','UserController@unfollow');
