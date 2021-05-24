<?php

namespace Modules\Exercise07\Tests\Unit\Services;

use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    /**
     * @param $input
     * @param $expected
     * @dataProvider amountLessThanFreeShipping
     * @dataProvider amountGreateThanFreeShippingAndIsPremiumMember
     * @dataProvider isPremiumMember
     */
    public function test_calculate_shipping_fee_function($input, $expected)
    {
        $checkoutService = new CheckoutService();

        $result = $checkoutService->calculateShippingFee($input);

        $this->assertEquals($expected, $result);
    }

    public function amountLessThanFreeShipping()
    {
        return [
            [
                [
                    'amount' => 10,
                ],
                [
                    'amount' => 10,
                    'shipping_fee' => 500,
                ]
            ],
        ];
    }

    public function isPremiumMember()
    {
        return [
            [
                [
                    'amount' => 10,
                    'premium_member' => 1,
                    'shipping_express' => 1,
                ],
                [
                    'amount' => 10,
                    'shipping_fee' => 500,
                    'premium_member' => 1,
                    'shipping_express' => 1,
                ]
            ],
        ];
    }

    public function amountGreateThanFreeShippingAndIsPremiumMember()
    {
        return [
            [
                [
                    'amount' => 5001,
                    'premium_member' => 1,
                ],
                [
                    'amount' => 5001,
                    'shipping_fee' => 0,
                    'premium_member' => 1,
                ]
            ],
        ];
    }
}
