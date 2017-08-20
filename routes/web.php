<?php

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth','admin'])->group(function() {
	Route::get('/', 'VideoController@index');
	Route::post('videos/video', 'VideoController@uploadVideo');
	Route::resource('videos', 'VideoController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
