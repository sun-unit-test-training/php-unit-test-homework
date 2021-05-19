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
     * @param $expectedValue
     * @dataProvider provideData
     * */
    public function test_calculate_shipping_fee($order, $expectedValue)
    {
        $resultOrder = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals($expectedValue, $resultOrder);
    }

    public function provideData()
    {
        return [
            [
                [
                    'amount' => 2000,
                ],
                [
                    'shipping_fee' => 500,
                    'amount' => 2000,
                ]
            ],
            [
                [
                    'amount' => 2000,
                    'premium_member' => 1,
                ],
                [
                    'shipping_fee' => 0,
                    'amount' => 2000,
                    'premium_member' => 1,
                ]
            ],
        ];
    }
}
