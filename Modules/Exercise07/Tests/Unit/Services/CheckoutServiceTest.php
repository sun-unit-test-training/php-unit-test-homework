<?php

namespace Modules\Exercise07\Tests\Unit\Services;

use Modules\Exercise07\Services\CheckoutService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CheckoutService();
    }

    /**
     * @dataProvider provideData
     */
    public function test_calculate_shipping_fee($inputData, $expected)
    {
        $order = $this->service->calculateShippingFee($inputData);
        $this->assertEquals($expected, $order);
    }

    public function provideData()
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
