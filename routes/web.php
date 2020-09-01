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


Auth::routes();





