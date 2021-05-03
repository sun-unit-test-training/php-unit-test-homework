<?php

namespace Modules\Exercise07\Tests;

use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CheckoutService();
    }

    /**
     * @dataProvider input_for_calculate_shipping_fee
     * @param $input
     * @param $expected
     */
    public function test_calculate_shipping_fee($input, $expected)
    {
        $order = $this->service->calculateShippingFee($input);
        $this->assertEquals($expected, $order);
    }

    public function input_for_calculate_shipping_fee()
    {
        return [
            [
                [
                    'amount' => 10,
                    'premium_member' => 1,
                    'shipping_express' => 1,
                ], [
                    'amount' => 10,
                    'premium_member' => 1,
                    'shipping_express' => 1,
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 10,
                    'shipping_express' => 1,
                ], [
                    'amount' => 10,
                    'shipping_express' => 1,
                    'shipping_fee' => 1000,
                ]
            ],
            [
                [
                    'amount' => 5000,
                    'shipping_express' => 1,
                ], [
                    'amount' => 5000,
                    'shipping_express' => 1,
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 5000,
                ], [
                    'amount' => 5000,
                    'shipping_fee' => 0,
                ]
            ],
        ];
    }
}
