<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Reference;
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


$factory->define(Reference::class, function (Faker $faker) {

  return [
        'name' => $faker->word,
        'type_id' => $faker->randomNumber(2),
        'price' => $faker->randomNumber(3),
        'description' => $faker->text
    ];
});
