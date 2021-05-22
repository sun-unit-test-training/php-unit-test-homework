<?php

namespace Modules\Exercise07\Tests\Unit\Services;

use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    protected $checkoutService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutService = new CheckoutService();
    }

    /**
     * @param $order
     * @param $expected
     * @dataProvider provide_order_data
     * */
    public function test_calculate_shipping_fee($order, $expected)
    {
        $response = $this->checkoutService->calculateShippingFee($order);

        $this->assertEquals($expected, $response);
    }

    public function provide_order_data()
    {
        return [
            [
                [
                    'amount' => 10000,
                ],
                [
                    'shipping_fee' => 0,
                    'amount' => 10000,
                ]
            ],
            [
                [
                    'amount' => 1000,
                ],
                [
                    'shipping_fee' => 500,
                    'amount' => 1000,
                ]
            ],
            [
                [
                    'amount' => 1000,
                    'premium_member' => 1,
                ],
                [
                    'shipping_fee' => 0,
                    'amount' => 1000,
                    'premium_member' => 1,
                ]
            ],
        ];
    }
}
