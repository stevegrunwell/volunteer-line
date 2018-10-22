<?php

use Faker\Generator as Faker;

$factory->define(App\PhoneNumber::class, function (Faker $faker) {
    return [
        'number' => $faker->e164PhoneNumber,
        'name' => $faker->text,
    ];
});
