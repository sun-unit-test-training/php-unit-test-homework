<?php

namespace Modules\Exercise07\Tests\Unit\Services;

use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new CheckoutService();
    }

    /**
     * @param $order
     * @param $expected
     * @dataProvider provide_order_data
     * */
    public function test_calculate_shipping_fee($order, $expected)
    {
        $response = $this->service->calculateShippingFee($order);

        $this->assertEquals($expected, $response);
    }

    public function provide_order_data()
    {
        return [
            [
                [
                    'amount' => 8000,
                ],
                [
                    'shipping_fee' => 0,
                    'amount' => 8000,
                ]
            ],
            [
                [
                    'amount' => 2500,
                ],
                [
                    'shipping_fee' => 500,
                    'amount' => 2500,
                ]
            ],
            [
                [
                    'amount' => 500,
                    'premium_member' => 1,
                ],
                [
                    'shipping_fee' => 0,
                    'amount' => 500,
                    'premium_member' => 1,
                ]
            ],
        ];
    }
}
