<?php

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth','admin'])->group(function() {
	Route::get('/', 'PostController@index');
	Route::post('videos/uploadVideo/{video}', 'VideoController@uploadVideo');
	Route::resource('posts', 'PostController');
	Route::resource('videos', 'VideoController');
	Route::resource('images', 'ImageController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
