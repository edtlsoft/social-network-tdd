<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home');


Route::post('/statuses', 'StatusController@store')->name('statuses.store');


Auth::routes();





