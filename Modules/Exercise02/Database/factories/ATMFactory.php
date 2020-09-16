<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Modules\Exercise02\Models\ATM;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(ATM::class, function () {
    return [
        'card_id' => Str::random(5),
    ];
});

$factory->state(ATM::class, 'is_vip', [
    'is_vip' => true,
]);

$factory->state(ATM::class, 'is_not_vip', [
    'is_vip' => false,
]);
