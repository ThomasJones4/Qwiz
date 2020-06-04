<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Response;
use Faker\Generator as Faker;

$factory->define(Response::class, function (Faker $faker) {
    return [
      'scheduled_start' => $faker->dateTime(),
      'name' => 'The ' . $faker->sentence(2) . ' Quiz',
      'invite_code' => $faker->randomNumber(8),
    ];
});
