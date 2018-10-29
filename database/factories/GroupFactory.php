<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'key' => str_random(32),
        'created_by' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
