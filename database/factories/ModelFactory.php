<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    $title = $faker->sentence;
    return [
        'title' => ucwords($title),
        'slug' => str_replace(' ', '-', strtolower($title))
    ];
});

$factory->define(App\Video::class, function (Faker\Generator $faker) {
    $post = factory('App\Post')->create();
    return [
        'post_id' => $post->id,
        'slug' => $post->slug.'-1',
        'link' => 'video/'.$faker->image(storage_path('app/public/video'),'640','480',null,false),
    ];
});

$factory->define(App\Image::class, function (Faker\Generator $faker) {
    return [
        'slug' => 'upload/'.$faker->image(storage_path('app/public/upload'),'640','480',null,false),
    ];
});
