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
        'title' => $title,
        'slug' => str_replace(' ', '-', strtolower($title))
    ];
});

$factory->define(App\Video::class, function (Faker\Generator $faker) {
    return [
        'post_id' => factory('App\Post')->create()->id,
        'slug' => $faker->word,
        'link' => $faker->sentence,
    ];
});

$factory->define(App\Image::class, function (Faker\Generator $faker) {
    return [
        'post_id' => factory('App\Post')->create()->id,
        'video_id' => factory('App\Video')->create()->id,
        'slug' => $faker->word,
    ];
});
