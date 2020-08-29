<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');

// Statuses routes
Route::get('/statuses', 'StatusController@index')->name('statuses.index');
Route::post('/statuses', 'StatusController@store')->name('statuses.store');

// Statuses likes routes
Route::post('/statuses/{status}/like', 'StatusLikeController@store')->name('statuses.like.store');
Route::delete('/statuses/{status}/like', 'StatusLikeController@destroy')->name('statuses.like.destroy');

// Statuses comments
Route::post('/statuses/{status}/comments', 'StatusCommentController@store')->name('statuses.comments.store');

// Comments likes routes
Route::post('/comments/{status}/like', 'CommentLikeController@store')->name('comments.like.store');
Route::delete('/comments/{status}/like', 'CommentLikeController@destroy')->name('comments.like.destroy');


Auth::routes();





