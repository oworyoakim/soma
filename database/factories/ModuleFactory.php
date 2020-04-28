<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Module;
use Faker\Generator as Faker;

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

$factory->define(Module::class, function (Faker $faker) {
    return [
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'weight' => random_int(2,5),
        'duration' => $this->faker->randomElement([10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100]),
        'outline' => $this->faker->paragraph(5),
    ];
});
