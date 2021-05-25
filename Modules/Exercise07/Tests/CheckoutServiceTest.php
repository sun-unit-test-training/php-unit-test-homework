<?php

namespace Modules\Exercise05\Tests;

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
     * @dataProvider caseForTest
     * @param $amount
     * @param $premiumMember
     * @param $shippingExpress
     * @param $result
     */
    public function testCalculateShippingFee($amount, $premiumMember, $shippingExpress, $result)
    {
        $order = [
            'amount' => $amount,
            'premium_member' => $premiumMember,
            'shipping_express' => $shippingExpress,
        ];
        $order = $this->service->calculateShippingFee($order);

        $this->assertEquals($result, $order);
    }

    public function caseForTest()
    {
        return [
            [
                6000,
                1,
                null,
                [
                    'amount' => 6000,
                    'premium_member' => 1,
                    'shipping_express' => null,
                    'shipping_fee' => 0,
                ],
            ],
        ];
    }
}