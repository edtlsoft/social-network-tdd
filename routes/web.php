<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function(){ return 'Login...'; })->name('login');

Route::post('/statuses', 'StatusController@store')->name('statuses.store');

