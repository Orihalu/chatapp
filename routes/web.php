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
    return redirect('/home');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/rooms', 'RoomController@index');
Route::post('/rooms', 'RoomController@search');
// Route::get('/room/{room}', 'RoomController@show')->where('id','[0-9]+');
Route::get('/room/create', 'RoomController@create');
Route::get('/room/{room}', 'RoomController@show')->where('id','[0-9]+');
Route::post('/room/store', 'RoomController@store');
Route::delete('/room/{id}', 'CommentController@destroy');
Route::post('/room/{id}/like','UserController@like');
Route::post('/room/{id}/unlike','UserController@unlike');
Route::post('/room/{id}/join','UserController@join');
Route::post('/room/{id}/leave', 'UserController@leave');



Route::post('/users','UserController@search');
Route::get('/users/{user}', 'UserController@show')->where('id','[0-9]+')->name('user');
Route::get('/users', 'UserController@index');
Route::post('/users/{user}/follow', 'UserController@follow');
Route::post('/users/{user}/unfollow','UserController@unfollow');




Route::get('/admin/index','AdminController@index');
Route::get('/admin/users','AdminController@showUsers');
Route::get('/admin/rooms','AdminController@showRooms');
Route::get('/admin/users/{user}/edit','AdminController@edit')->where('id','[0-9]+');
// Route::patch('/users/{user}','AdminController@update');
Route::patch('/api/users/{user}/update','UserController@update');

Route::get('/api/favorite/comments','CommentController@indexOfFavorites');


Route::middleware('auth')->group(function () {
  Route::get('/api/room/{id}/user/{user}/comments','CommentController@index')->where('id','[0-9]+');
  Route::get('/api/user/{user}/comments','UserController@favorite')->where('id','[0-9]+');
  Route::post('/api/create/{user}','RoomController@store')->where('id','[0-9]+');
  Route::get('/api/user','UserController@getAuthUser');
  Route::get('/api/room/','RoomController@getRoom');
  Route::post('/api/user/register','Auth\RegisterController@register');
  Route::delete('/api/room/{id}/delete','RoomController@destroy');
});
