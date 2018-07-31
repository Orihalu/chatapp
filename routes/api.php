<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('room/{id}/comments','CommentController@index')->where('id','[0-9]+');

Route::patch('/users/{user}/update','AdminController@update');
Route::get('/user/{id}/comments', 'UserController@favorite');

Route::get('comments/{comment}/favorites/count','CommentController@count');


Route::middleware('auth:api')->group(function () {
    Route::post('room/{id}/comment', 'CommentController@store')->where('id','[0-9]+');
    Route::post('comment/{id}/likes','UserController@like');

});
