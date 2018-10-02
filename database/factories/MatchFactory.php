<?php

use App\Models\Match;
use Faker\Generator as Faker;

$factory->define(Match::class, function (Faker $faker) {
    $next = [1, 2];
    $states = [0, 1, 2];
    return [
        'name' => $faker->name,
        'next' => $faker->randomElement($next),
        'winner' => $faker->randomElement($states),
        'board' => $faker->randomElements($states, 9, true)
    ];
});
