<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('welcome');
});


Route::post('/statuses', 'StatusController@store')->name('statuses.store');


Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');



