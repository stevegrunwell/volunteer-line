<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'created_by' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
