<?php

namespace Modules\Exercise02\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Exercise02\Models\ATM;

class ATMFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ATM::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'card_id' => Str::random(5),
        ];
    }

    public function isVip()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_vip' => true,
            ];
        });
    }

    public function isNotVip()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_vip' => false,
            ];
        });
    }
}
