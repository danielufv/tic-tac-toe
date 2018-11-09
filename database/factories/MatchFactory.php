<?php

use App\Models\Match;
use App\Models\MainMatch;
use Faker\Generator as Faker;

$factory->define(Match::class, function (Faker $faker) {
    $next = [1, 2];
    $states = [0, 1, 2];
    return [
        'main_match_id' => function () use ($faker) {
            return factory(MainMatch::class)->create()->id;
        },
        'name' => $faker->name,
        'next' => $faker->randomElement($next),
        'winner' => $faker->randomElement($states),
        'board' => $faker->randomElements($states, 9, true)
    ];
});
