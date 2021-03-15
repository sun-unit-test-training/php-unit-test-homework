<?php

namespace Modules\Exercise03\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Exercise03\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'thumbnail' => $this->faker->image(),
        ];
    }

    public function cravat()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Product::CRAVAT_TYPE,
            ];
        });
    }

    public function whiteShirt()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Product::WHITE_SHIRT_TYPE,
            ];
        });
    }

    public function other()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Product::OTHER_TYPE,
            ];
        });
    }
}
