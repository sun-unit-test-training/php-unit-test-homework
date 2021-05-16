<?php

namespace Modules\Exercise07\Tests\Unit\Services;

use Modules\Exercise07\Services\CheckoutService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CheckoutService();
    }

    /**
     * @dataProvider provideData
     */
    public function test_it_calculate_shipping_fee($shippingFee, $order)
    {
        $result = $this->service->calculateShippingFee($order);
        $order['shipping_fee'] = $shippingFee;

        $this->assertEquals($result, $order);
    }

    function provideData()
    {
        return [
            'Amount >= 5000 and No Preminum Member and Shipping Express' => [
                500,
                [
                    'amount' => 5000,
                    'shipping_express' => true
                ]
            ],
            'Amount >= 5000 and No Preminum Member and No Shipping Express' => [
                0,
                [
                    'amount' => 5000,
                ]
            ],
            'Amount < 5000 and Preminum Member and Shipping Express' => [
                500,
                [
                    'amount' => 4999,
                    'premium_member' => true,
                    'shipping_express' => true
                ]
            ],
            'Amount < 5000 and Preminum Member and No Shipping Express' => [
                0,
                [
                    'amount' => 4999,
                    'premium_member' => true,
                ]
            ],
        ];
    }
}
