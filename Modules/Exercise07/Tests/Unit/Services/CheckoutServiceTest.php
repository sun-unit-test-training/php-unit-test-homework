<?php

namespace Tests\Unit\Services;

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
     * @dataProvider dataCalculateShippingFee
     */
    public function testCalculate($input, $order)
    {
        $result = $this->service->calculateShippingFee($input);

        $this->assertEquals($order['shipping_fee'], $result['shipping_fee']);
    }

    public function dataCalculateShippingFee()
    {
        return [
            [
                [
                    'amount' => 999,
                    'shipping_express' => true,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 999,
                    'shipping_express' => true,
                    'premium_member' => false,
                ], [
                    'shipping_fee' => 1000,
                ]
            ],
            [
                [
                    'amount' => 999,
                    'shipping_express' => false,
                    'premium_member' => false,
                ], [
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 1999,
                    'shipping_express' => false,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 0,
                ]
            ],
            [
                [
                    'amount' => 6969,
                    'shipping_express' => true,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 6969,
                    'shipping_express' => true,
                    'premium_member' => false,
                ], [
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 6000,
                    'shipping_express' => false,
                    'premium_member' => false,
                ], [
                    'shipping_fee' => 0,
                ]
            ],
            [
                [
                    'amount' => 9999,
                    'shipping_express' => false,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 0,
                ]
            ],
            [
                [
                    'amount' => 1,
                    'shipping_express' => true,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 500,
                ]
            ],
        ];
    }
}