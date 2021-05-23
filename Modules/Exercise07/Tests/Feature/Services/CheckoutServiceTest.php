<?php

namespace Modules\Tests\Exercise07\Tests\Http\Services;

use InvalidArgumentException;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    private $checkoutService;

    public function setUp(): void
    {
        parent::setUp();
        $this->checkoutService = new CheckoutService();
    }

    /**
     * @dataProvider provideData
     */
    public function testCalculateShippingFee($order, $expectValue, $testCase = 'OK')
    {
        $response = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals($response, $expectValue);
    }

    public function provideData()
    {
        return [
            [
                $this->makeOrder(5000, null),
                $this->makeOrder(5000, null, 0)
            ],
            [
                $this->makeOrder(5001, null),
                $this->makeOrder(5001, null, 0)
            ],
            [
                $this->makeOrder(4999, null, null, 'premium_member'),
                $this->makeOrder(4999, null, 0, 'premium_member')
            ],
        ];
    }

    public function makeOrder($amount, $express, $fee = null, $premiumMember = null)
    {
        return [
            'amount' => $amount,
            'shipping_express' => $express,
            'shipping_fee' => $fee,
            'premium_member' => $premiumMember
        ];
    }
}
