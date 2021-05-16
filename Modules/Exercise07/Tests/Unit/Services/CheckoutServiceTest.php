<?php

namespace Modules\Exercise07\Tests\Unit\Services;

use Tests\TestCase;
use InvalidArgumentException;
use Modules\Exercise07\Services\CheckoutService;
use Modules\Exercise07\Constants\Checkout;

class CheckoutServiceTest extends TestCase
{
    protected $service;
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new CheckoutService();
    }

    function test_calculate_shipping_fee_success()
    {
        foreach ($this->getOrderData() as $order) {
            $shippingFee = Checkout::SHIPPING_FEE;
            $shippingExpressFee = Checkout::SHIPPING_EXPRESS_FEE;

            if ($order['amount'] >= Checkout::FREE_SHIPPING_AMOUNT || !empty($order['premium_member'])) {
                $shippingFee = 0;
            }

            if (empty($order['shipping_express'])) {
                $shippingExpressFee = 0;
            }

            $expectedOrder = $order;
            $expectedOrder['shipping_fee'] = $shippingFee + $shippingExpressFee;

            $orderResult = $this->service->calculateShippingFee($order);

            $this->assertEquals($expectedOrder, $orderResult);
        }
    }

    private function getOrderData()
    {
        return [
            [
                'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
                'premium_member' => '',
                'shipping_express' => 'shipping_express_example',
            ],
            [
                'amount' => Checkout::FREE_SHIPPING_AMOUNT,
                'premium_member' => '',
                'shipping_express' => 'shipping_express_example',
            ],
            [
                'amount' => Checkout::FREE_SHIPPING_AMOUNT + 1,
                'premium_member' => '',
                'shipping_express' => 'shipping_express_example',
            ],
            [
                'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
                'premium_member' => 'premium_member_example',
                'shipping_express' => 'shipping_express_example',
            ],
            [
                'amount' => 1,
                'premium_member' => 'premium_member_example',
                'shipping_express' => 'shipping_express_example',
            ],
            [
                'amount' => 1,
                'premium_member' => 'premium_member_example',
                'shipping_express' => '',
            ],
            [
                'amount' => 1,
                'premium_member' => '',
                'shipping_express' => '',
            ],
        ];
    }
}
