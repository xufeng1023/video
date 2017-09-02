<?php

Route::get('/', 'Front\PostController@index');

Route::prefix('admin')->middleware(['auth','admin'])->group(function() {
	Route::get('/', 'PostController@index');
	Route::post('/videos/thumbnail/{video}', 'VideoController@thumbnail');
	Route::get('/posts/search', 'PostController@search');
	Route::resource('posts', 'PostController');
	Route::resource('videos', 'VideoController');
	Route::patch('/videos/{video}/preview', 'VideoController@setPreview');
	Route::resource('images', 'ImageController');
	//
	Route::get('/factory', function() {
		factory('App\Video', 20)->create()->each(function($video) {
			factory('App\Image')->create([
				'post_id' => $video->post->id,
				'is_thumbnail' => 1
			]);
			factory('App\Image')->create(['post_id' => $video->post->id]);
			factory('App\Image')->create(['video_id' => $video->id]);
		});
	});
	//
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
