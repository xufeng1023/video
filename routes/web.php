<?php

Route::get('/', 'Front\PostController@index');

Route::prefix('admin')->middleware(['auth','admin'])->group(function() {
	Route::get('/', 'PostController@index');
	Route::post('/videos/thumbnail/{video}', 'VideoController@thumbnail');
	Route::get('/posts/search', 'PostController@search');
	Route::resource('posts', 'PostController');
	Route::resource('videos', 'VideoController');
	Route::resource('images', 'ImageController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
