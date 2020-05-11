<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use App\Author;
use App\Publisher;
use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Category;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'isbn' => $faker->isbn10,
        'title' => $faker->paragraph,
        'pub_date' => Carbon::now()->subYear(rand(10, 20)),
        'pub_id'    => function() {
            return factory(Publisher::class)->create()->id;
        },
        'author_id' => function() {
            return factory(Author::class)->create()->id;
        },
        'category_id' => function() {
            return factory(Category::class)->create()->id;
        },
        'price' => rand(100, 1000)
    ];
});
