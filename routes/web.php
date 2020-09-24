<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');

// Statuses routes
Route::get('/statuses', 'StatusController@index')->name('statuses.index');
Route::post('/statuses', 'StatusController@store')->name('statuses.store');

// Statuses likes routes
Route::post('/statuses/{status}/likes', 'StatusLikeController@store')->name('statuses.like.store');
Route::delete('/statuses/{status}/likes', 'StatusLikeController@destroy')->name('statuses.like.destroy');

// Statuses comments
Route::post('/statuses/{status}/comments', 'StatusCommentController@store')->name('statuses.comments.store');

// Comments likes routes
Route::post('/comments/{comment}/likes', 'CommentLikeController@store')->name('comments.like.store');
Route::delete('/comments/{comment}/likes', 'CommentLikeController@destroy')->name('comments.like.destroy');

// Users
Route::get('/@{user}', 'UserController@show')->name('users.show');

// Users statuses
Route::get('/users/{user}/statuses', 'UserStatusController@index')->name('users.statuses.index');

// Friendship
Route::post('/friendship/{recipient}', 'FriendshipController@store')->name('friendship.store');
Route::delete('/friendship/{recipient}', 'FriendshipController@destroy')->name('friendship.destroy');

// Request Friendship
Route::post('/accept-friendship/{sender}', 'AcceptFriendshipController@store')->name('accept-friendship.store');
Route::delete('/accept-friendship/{sender}', 'AcceptFriendshipController@destroy')->name('accept-friendship.destroy');


Auth::routes();

