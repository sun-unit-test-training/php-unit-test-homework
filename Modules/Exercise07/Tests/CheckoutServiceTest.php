<?php

namespace Modules\Exercise07\Tests;

use Carbon\Carbon;
use Tests\TestCase;
use Modules\Exercise07\Constants\Checkout;
use Modules\Exercise04\Services\CalendarService;
use Modules\Exercise07\Services\CheckoutService;

class CheckoutServiceTest extends TestCase
{
    protected $checkoutService;

    public function setUp(): void
    {
        parent::setUp();
        $this->checkoutService = new CheckoutService();
    }

    public function test_calculate_shipping_fee_with_amount_greater_than_free_shipping_amount_and_not_shipping_express()
    {
        $order = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT + 1,
        ];
        $result = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals(0, $result['shipping_fee']);
    }

    public function test_calculate_shipping_fee_with_amount_greater_than_free_shipping_amount_and_shipping_express()
    {
        $order = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT + 1,
            'shipping_express' => true,
        ];
        $result = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals(Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
    }

    public function test_calculate_shipping_fee_with_amount_equal_free_shipping_amount_and_not_shipping_express()
    {
        $order = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT,
        ];
        $result = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals(0, $result['shipping_fee']);
    }

    public function test_calculate_shipping_fee_with_amount_equal_free_shipping_amount_and_shipping_express()
    {
        $order = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT,
            'shipping_express' => true,
        ];
        $result = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals(Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
    }

    public function test_calculate_shipping_fee_with_premium_member_and_not_shipping_express()
    {
        $order = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
            'premium_member' => true,
        ];
        $result = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals(0, $result['shipping_fee']);
    }

    public function test_calculate_shipping_fee_with_premium_member_and_shipping_express()
    {
        $order = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
            'premium_member' => true,
            'shipping_express' => true,
        ];
        $result = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals(Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
    }

    public function test_calculate_shipping_fee_with_amount_less_than_free_shipping_amount_and_not_premium_member_and_not_shipping_express()
    {
        $order = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
        ];
        $result = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals(Checkout::SHIPPING_FEE, $result['shipping_fee']);
    }

    public function test_calculate_shipping_fee_with_amount_less_than_free_shipping_amount_and_not_premium_member_and_shipping_express()
    {
        $order = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
            'shipping_express' => true,
        ];
        $result = $this->checkoutService->calculateShippingFee($order);
        $this->assertEquals(Checkout::SHIPPING_FEE + Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
    }
}
