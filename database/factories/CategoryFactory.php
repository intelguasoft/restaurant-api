<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use IntelGUA\FoodPoint\Models\Category as Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 450),
    ];
});
