<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Course::class, function (Faker $faker) {
    $title = $this->faker->sentence;
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'code' => $this->faker->randomNumber(5),
        'description' => $this->faker->paragraph,
        'duration' => random_int(10, 60),
        'weight' => random_int(2, 5),
        'thumbnail' => $this->faker->imageUrl(),
    ];
});
