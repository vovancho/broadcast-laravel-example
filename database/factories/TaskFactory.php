<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'name' => title_case($faker->unique()->words($nb = rand(2, 6), true)),
        'percent' => 0,
        'status' => \App\Task::IN_QUEUE,
    ];
});
