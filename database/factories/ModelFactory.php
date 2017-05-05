<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Korona\User::class, function (Faker\Generator $faker) {
    return [
        'login' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'active' => true,
        'force_password_change' => false
    ];
});

$factory->define(Bican\Roles\Models\Permission::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(rand(3, 5), true),
        'slug' => str_slug($faker->words(rand(3, 5), true), '.'),
        'description' => $faker->sentence
    ];
});

$factory->define(Bican\Roles\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(rand(3, 5), true),
        'slug' => str_slug($faker->words(rand(3, 5), true), '.'),
        'description' => $faker->sentence,
        'level' => 1
    ];
});
