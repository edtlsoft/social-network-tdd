<?php

use Illuminate\Support\Facades\Route;


Route::post('/statuses', 'StatusController@store')->name('statuses.store');


Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
