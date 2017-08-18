<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'is_admin' => 0,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Video::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'slug' => $faker->word,
        'link' => 'test.mp4',
        'thumbnail' => 'test.jpg',
        'views' => 0,
    ];
});

$factory->define(App\Image::class, function (Faker\Generator $faker) {
    return [
        'video_id' => factory('App\Video')->create()->id,
        'title' => $faker->sentence,
        'slug' => $faker->word,
    ];
});
