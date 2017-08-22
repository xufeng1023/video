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
    return [
        'title' => $faker->sentence,
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
        'slug' => $faker->word,
    ];
});
