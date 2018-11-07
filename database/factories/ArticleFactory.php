<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'author' => $faker->name,
        'department' => $faker->text(20),
    ];
});
