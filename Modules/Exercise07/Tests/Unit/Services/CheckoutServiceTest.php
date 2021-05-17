<?php

namespace Tests\Unit\Services;

use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    protected $calendarServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CheckoutService();
    }

    /**
     * @dataProvider provider_test_calculate_shipping_fee
     */
    public function test_calculate($input, $order)
    {
        $result = $this->service->calculateShippingFee($input);

        $this->assertEquals($order['shipping_fee'], $result['shipping_fee']);
    }

    public function provider_test_calculate_shipping_fee()
    {
        return [
            [
                [
                    'amount' => 1000,
                    'shipping_express' => true,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 1000,
                    'shipping_express' => true,
                    'premium_member' => false,
                ], [
                    'shipping_fee' => 1000,
                ]
            ],
            [
                [
                    'amount' => 1000,
                    'shipping_express' => false,
                    'premium_member' => false,
                ], [
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 1000,
                    'shipping_express' => false,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 0,
                ]
            ],
            [
                [
                    'amount' => 6000,
                    'shipping_express' => true,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 500,
                ]
            ],
            [
                [
                    'amount' => 6000,
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
                    'amount' => 6000,
                    'shipping_express' => false,
                    'premium_member' => true,
                ], [
                    'shipping_fee' => 0,
                ]
            ],
        ];
    }
}
