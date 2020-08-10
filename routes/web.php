<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');


Route::get('/statuses', 'StatusController@index')->name('statuses.index');
Route::post('/statuses', 'StatusController@store')->name('statuses.store');


Auth::routes();





