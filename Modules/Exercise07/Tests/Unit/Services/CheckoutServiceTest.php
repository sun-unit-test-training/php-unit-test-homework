<?php

namespace Modules\Exercise07\Tests\Unit\Services;

use Modules\Exercise07\Constants\Checkout;
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
     * @dataProvider provider_calculate_shipping_fee
     */
    public function test_calculate_shipping_fee($input, $expected)
    {
        $orderResponse = $this->checkoutService->calculateShippingFee($input);
        $this->assertEquals($expected['shipping_fee'], $orderResponse['shipping_fee']);
    }

    function provider_calculate_shipping_fee()
    {
        return [
            [
                [
                    'amount' => Checkout::FREE_SHIPPING_AMOUNT
                ],
                [
                    'shipping_fee' => 0,
                ]
            ],
            [
                [
                    'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
                    'premium_member' => true,
                    'shipping_express' => true,
                ],
                [
                    'shipping_fee' => Checkout::SHIPPING_EXPRESS_FEE,
                ]
            ],
            [
                [
                    'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
                    'shipping_express' => true,
                ],
                [
                    'shipping_fee' => Checkout::SHIPPING_EXPRESS_FEE + Checkout::SHIPPING_FEE,
                ]
            ],
            [
                [
                    'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
                ],
                [
                    'shipping_fee' => Checkout::SHIPPING_FEE,
                ]
            ],
        ];
    }
}
