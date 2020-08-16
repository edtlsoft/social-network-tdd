<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');

// Statuses routes
Route::get('/statuses', 'StatusController@index')->name('statuses.index');
Route::post('/statuses', 'StatusController@store')->name('statuses.store');

// Statuses likes routes
Route::post('/statuses/{status}/like', 'StatusLikeController@store')->name('statuses.like.store');
Route::delete('/statuses/{status}/like', 'StatusLikeController@destroy')->name('statuses.like.destroy');



Auth::routes();





