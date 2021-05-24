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
    public function test_calculate_shipping_fee($shippingFee, $order)
    {
        $result = $this->checkoutService->calculateShippingFee($order);
        $order['shipping_fee'] = $shippingFee;

        $this->assertEquals($result, $order);
    }

    function provider_calculate_shipping_fee()
    {
        return [
            'Amount >= 5000 and No Premium Member and Shipping Express' => [
                500,
                [
                    'amount' => Checkout::FREE_SHIPPING_AMOUNT,
                    'shipping_express' => true
                ]
            ],
            'Amount >= 5000 and No Premium Member and No Shipping Express' => [
                0,
                [
                    'amount' => Checkout::FREE_SHIPPING_AMOUNT + 1,
                ]
            ],
            'Amount < 5000 and Premium Member and Shipping Express' => [
                500,
                [
                    'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
                    'premium_member' => true,
                    'shipping_express' => true
                ]
            ],
            'Amount < 5000 and Premium Member and No Shipping Express' => [
                0,
                [
                    'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
                    'premium_member' => true,
                ]
            ],
        ];
    }
}
