<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(2),
        'question' => $faker->sentence(5) . '?',
        'released' => '0',
        'correct_answer' => null,
    ];
});
