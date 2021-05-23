<?php

namespace Modules\Exercise07\Tests\Unit;

use InvalidArgumentException;
use Tests\TestCase;
use Modules\Exercise07\Services\CheckoutService;

class CheckoutServiceTest extends TestCase
{
    private $checkoutService;

    public function setUp(): void
    {
        parent::setUp();
        $this->checkoutService = new CheckoutService();
    }

    public function providerValidData()
    {
        return [
            [
                [
                    'amount' => 6000,
                    'premium_member' => true,
                    'shipping_express' => '',
                    'shipping_fee' => 0,
                ],
            ],
            [
                [
                    'amount' => 6000,
                    'premium_member' => '',
                    'shipping_express' => '',
                    'shipping_fee' => 0,
                ],
            ],
            [
                [
                    'amount' => 4000,
                    'premium_member' => true,
                    'shipping_express' => '',
                    'shipping_fee' => 0,
                ],
            ],
            [
                [
                    'amount' => 4000,
                    'premium_member' => '',
                    'shipping_express' => '',
                    'shipping_fee' => 500,
                ],
            ],
            [
                [
                    'amount' => 6000,
                    'premium_member' => true,
                    'shipping_express' => true,
                    'shipping_fee' => 500,
                ],
            ],
            [
                [
                    'amount' => 6000,
                    'premium_member' => '',
                    'shipping_express' => true,
                    'shipping_fee' => 500,
                ],
            ],
            [
                [
                    'amount' => 4000,
                    'premium_member' => true,
                    'shipping_express' => true,
                    'shipping_fee' => 500,
                ],
            ],
            [
                [
                    'amount' => 4000,
                    'premium_member' => '',
                    'shipping_express' => true,
                    'shipping_fee' => 1000,
                ],
            ]
        ];
    }

    /**
     * @dataProvider providerValidData
     */
    public function test_calculateShippingFee($order)
    {
        $result = $this->checkoutService->calculateShippingFee($order);

        $this->assertEquals($result, $order);
    }
}
