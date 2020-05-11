<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Author::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'dob' => Carbon::now()->subYear(rand(10,20)),
        'bibliography' => $faker->sentence(2)
    ];
});
