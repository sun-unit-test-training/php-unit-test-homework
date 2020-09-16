<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Exercise03\Entities\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'thumbnail' => $faker->image(),
    ];
});

$factory->state(Product::class, 'cravat', [
    'type' => Product::CRAVAT_TYPE,
]);

$factory->state(Product::class, 'white_shirt', [
    'type' => Product::WHITE_SHIRT_TYPE,
]);

$factory->state(Product::class, 'other', [
    'type' => Product::OTHER_TYPE,
]);
