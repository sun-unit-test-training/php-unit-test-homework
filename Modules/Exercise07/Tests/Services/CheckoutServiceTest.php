<?php
declare(strict_types=1);

namespace Modules\Exercise07\Services;

use Modules\Exercise07\Constants\Checkout;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    protected $checkoutService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->checkoutService = new CheckoutService();
    }

    public function testNormalCase()
    {
        $data = $this->getSampleData();

        $response = $this->checkoutService->calculateShippingFee($data);

        $this->assertEquals([
            'amount' => $data['amount'],
            'shipping_express' => null,
            'premium_member' => null,
            'shipping_fee' => Checkout::SHIPPING_FEE
        ], $response);
    }

    public function testShippingFeeCaseAmountGreaterThanEqual5000()
    {
        $data = $this->getSampleData();
        $data['amount'] = 5500;

        $response = $this->checkoutService->calculateShippingFee($data);
        $this->assertEquals([
            'amount' => 5500,
            'shipping_express' => null,
            'premium_member' => null,
            'shipping_fee' => 0
        ], $response);
    }

    public function testShippingFeeCaseShippingExpress()
    {
        $data = $this->getSampleData();
        $data['shipping_express'] = true;

        $response = $this->checkoutService->calculateShippingFee($data);
        $this->assertEquals([
            'amount' => $data['amount'],
            'shipping_express' => $data['shipping_express'],
            'premium_member' => $data['premium_member'],
            'shipping_fee' => Checkout::SHIPPING_FEE + Checkout::SHIPPING_EXPRESS_FEE
        ], $response);
    }

    public function testShippingFeeCasePremiumMember()
    {
        $data = $this->getSampleData();
        $data['premium_member'] = true;

        // case not shipping express
        $response = $this->checkoutService->calculateShippingFee($data);
        $this->assertEquals([
            'amount' => $data['amount'],
            'shipping_express' => $data['shipping_express'],
            'premium_member' => $data['premium_member'],
            'shipping_fee' => 0
        ], $response);

        // case shipping express
        $data['shipping_express'] = true;

        $response = $this->checkoutService->calculateShippingFee($data);
        $this->assertEquals([
            'amount' => $data['amount'],
            'shipping_express' => $data['shipping_express'],
            'premium_member' => $data['premium_member'],
            'shipping_fee' => Checkout::SHIPPING_EXPRESS_FEE
        ], $response);
    }

    public function getSampleData()
    {
        return [
            'amount' => 500,
            'shipping_express' => null,
            'premium_member' => null
        ];
    }
}
