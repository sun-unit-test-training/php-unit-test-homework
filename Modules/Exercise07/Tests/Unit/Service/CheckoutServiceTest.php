<?php

    namespace Modules\Exercise07\Tests\Unit\Service;

    use Modules\Exercise07\Constants\Checkout;
    use Tests\TestCase;
    use Modules\Exercise07\Services\CheckoutService;

    class CheckoutServiceTest extends TestCase
    {
        protected $checkoutService;

        public function setUp(): void
        {
            parent::setUp();
            $this->checkoutService = new CheckoutService();
        }

        public function test_calculate_shipping_fee_with_amount_greater_than_shipping_fee()
        {
            $order = [
                'amount' => 10000
            ];
            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(0, $result['shipping_fee']);
        }

        public function test_calculate_shipping_fee_with_amount_equal_shipping_fee()
        {
            $order = [
                'amount' => 5000
            ];
            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(0, $result['shipping_fee']);
        }

        public function test_calculated_shipping_fee_with_amount_less_than_shipping_fee()
        {
            $order = [
                'amount' => 1000
            ];
            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(Checkout::SHIPPING_FEE, $result['shipping_fee']);
        }


        public function test_calculated_shipping_fee_with_amount_greater_than_shipping_fee_and_has_premium_fee()
        {
            $order = [
                'amount' => 10000,
                'premium_member' => 1
            ];
            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(0, $result['shipping_fee']);
        }

        public function test_calculated_shipping_fee_with_amount_equal_shipping_fee_and_has_premium_fee()
        {
            $order = [
                'amount' => 5000,
                'premium_member' => 1
            ];

            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(0, $result['shipping_fee']);
        }

        public function test_calculated_shipping_fee_with_has_premium_member()
        {
            $order = [
                'amount' => 1000,
                'premium_member' => 1
            ];

            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(0, $result['shipping_fee']);
        }

        public function test_calculate_shipping_fee_with_amount_greater_than_shipping_fee_and_shipping_express()
        {
            $order = [
                'amount' => 10000,
                'shipping_express' => 1
            ];
            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
        }

        public function test_calculate_shipping_fee_with_amount_equal_shipping_fee_and_shipping_express()
        {
            $order = [
                'amount' => 5000,
                'shipping_express' => 1
            ];
            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
        }

        public function test_calculate_shipping_fee_with_shipping_express()
        {
            $order = [
                'amount' => 1000,
                'shipping_express' => 1
            ];

            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(Checkout::SHIPPING_FEE + Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
        }

        public function test_calculated_shipping_fee_with_amount_greater_than_shipping_fee_and_has_premium_fee_shipping_express()
        {
            $order = [
                'amount' => 10000,
                'premium_member' => 1,
                'shipping_express' => 1
            ];
            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
        }

        public function test_calculated_shipping_fee_with_amount_equal_shipping_fee_and_has_premium_fee_shipping_express()
        {
            $order = [
                'amount' => 5000,
                'premium_member' => 1,
                'shipping_express' => 1
            ];

            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
        }

        public function test_calculated_shipping_fee_with_has_premium_member_and_shipping_express()
        {
            $order = [
                'amount' => 1000,
                'premium_member' => 1,
                'shipping_express' => 1
            ];

            $result = $this->checkoutService->calculateShippingFee($order);
            $this->assertEquals(Checkout::SHIPPING_EXPRESS_FEE, $result['shipping_fee']);
        }
    }
