<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use IntelGUA\FoodPoint\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'email' => $faker->text($maxNbChars = 450),
    ];
});
