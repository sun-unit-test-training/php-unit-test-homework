<?php

namespace Modules\Exercise07\Tests\Unit;

use Tests\TestCase;
use Modules\Exercise07\Constants\Checkout;
use Modules\Exercise07\Services\CheckoutService;

/**
 * Class CheckoutServiceTest
 */
class CheckoutServiceTest extends TestCase
{
    /**
     * @var CheckoutService
     */
    protected $checkoutService;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->checkoutService = new CheckoutService();
    }

    /**
     * Calculate shipping fee when low amount and no shipping express
     *
     * @test
     *
     * @return void
     */
    public function calculate_shipping_fee_when_low_amount_and_no_shipping_express()
    {
        $amount = 100;
        $response = $this->checkoutService->calculateShippingFee([
            'amount' => $amount,
        ]);

        $this->assertEquals([
            'amount' => $amount,
            'shipping_fee' => Checkout::SHIPPING_FEE,
        ], $response);
    }

    /**
     * Calculate shipping fee when low amount and has shipping express
     *
     * @test
     *
     * @return void
     */
    public function calculate_shipping_fee_when_low_amount_and_has_shipping_express()
    {
        $amount = 100;
        $response = $this->checkoutService->calculateShippingFee([
            'amount' => $amount,
            'shipping_express' => true,
        ]);

        $this->assertEquals([
            'amount' => $amount,
            'shipping_express' => true,
            'shipping_fee' => Checkout::SHIPPING_FEE + Checkout::SHIPPING_EXPRESS_FEE,
        ], $response);
    }

    /**
     * Calculate shipping fee when is premium member and no shipping express
     *
     * @test
     *
     * @return void
     */
    public function calculate_shipping_fee_when_premium_and_no_shipping_express()
    {
        $amount = 100;
        $response = $this->checkoutService->calculateShippingFee([
            'amount' => $amount,
            'premium_member' => true,
        ]);

        $this->assertEquals([
            'amount' => $amount,
            'premium_member' => true,
            'shipping_fee' => 0,
        ], $response);
    }

    /**
     * Calculate shipping fee when is premium member and has shipping express
     *
     * @test
     *
     * @return void
     */
    public function calculate_shipping_fee_when_premium_and_has_shipping_express()
    {
        $amount = 100;
        $response = $this->checkoutService->calculateShippingFee([
            'amount' => $amount,
            'premium_member' => true,
            'shipping_express' => true,
        ]);

        $this->assertEquals([
            'amount' => $amount,
            'premium_member' => true,
            'shipping_express' => true,
            'shipping_fee' => Checkout::SHIPPING_EXPRESS_FEE,
        ], $response);
    }

    /**
     * Calculate shipping fee when high amount and no shipping express
     *
     * @test
     *
     * @return void
     */
    public function calculate_shipping_fee_when_high_amount_and_no_shipping_express()
    {
        $amount = 5000;
        $response = $this->checkoutService->calculateShippingFee([
            'amount' => $amount,
        ]);

        $this->assertEquals([
            'amount' => $amount,
            'shipping_fee' => 0,
        ], $response);
    }

    /**
     * Calculate shipping fee when high amount and has shipping express
     *
     * @test
     *
     * @return void
     */
    public function calculate_shipping_fee_when_high_amount_and_has_shipping_express()
    {
        $amount = 5000;
        $response = $this->checkoutService->calculateShippingFee([
            'amount' => $amount,
            'shipping_express' => true,
        ]);

        $this->assertEquals([
            'amount' => $amount,
            'shipping_express' => true,
            'shipping_fee' => Checkout::SHIPPING_EXPRESS_FEE,
        ], $response);
    }
}
