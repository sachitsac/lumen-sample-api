<?php

use Illuminate\Support\Facades\Hash;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make("secr3t12345", [
            'rounds' => 12
        ]),
    ];
});

$factory->define(App\Job::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(6),
        'description' => $faker->paragraph(),
        'location' => $faker->randomElement([
            'Victoria',
            'New South Wales',
            'Western Australia',
            'South Australia',
            'Queensland',
            'Tasmania'
        ]),
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
    ];
});
