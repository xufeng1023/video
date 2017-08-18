<?php

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware('admin')->group(function() {
	Route::get('/', 'VideoController@index');
	Route::resource('videos', 'VideoController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
