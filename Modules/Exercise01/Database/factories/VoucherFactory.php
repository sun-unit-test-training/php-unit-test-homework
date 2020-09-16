<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;
use Modules\Exercise01\Models\Voucher;

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

$factory->define(Voucher::class, function () {
    return [
        'code' => Str::random(5),
    ];
});

$factory->state(Voucher::class, 'active', [
    'is_active' => true,
]);

$factory->state(Voucher::class, 'inactive', [
    'is_active' => false,
]);
