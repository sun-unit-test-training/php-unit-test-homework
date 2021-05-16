<?php

namespace Modules\Exercise05\Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use InvalidArgumentException;
use Modules\Exercise05\Services\OrderService;

class OrderServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new OrderService();
    }

    function test_it_return_discount_pizza_only()
    {
        $config = config('exercise05');
        $detailOrder = [
            'price' => $config['price_has_discount_potato'] - 100,
            'option_receive' => $config['receive_at_home'] - 100,
        ];

        $expectedInfoBill = [
            'price' => $detailOrder['price'],
            'discount_pizza' => $config['discount_pizza'],
            'discount_potato' => null,
        ];

        $infoBill = $this->service->handleDiscount($detailOrder);

        $this->assertEquals($expectedInfoBill, $infoBill);
    }

    function test_it_return_discount_pizza_and_potato()
    {
        $config = config('exercise05');
        $detailOrder = [
            'price' => $config['price_has_discount_potato'] + 100,
            'option_receive' => $config['receive_at_home'] - 100,
        ];

        $expectedInfoBill = [
            'price' => $detailOrder['price'],
            'discount_pizza' => $config['discount_pizza'],
            'discount_potato' => $config['free_potato'],
        ];

        $infoBill = $this->service->handleDiscount($detailOrder);

        $this->assertEquals($expectedInfoBill, $infoBill);
    }

    function test_handle_discount_when_receive_at_home_with_coupon()
    {
        $config = config('exercise05');
        $detailOrder = [
            'price' => $config['price_has_discount_potato'] + 100,
            'option_receive' => $config['receive_at_home'],
            'option_coupon' => $config['has_coupon'],
        ];

        $expectedInfoBill = [
            'price' => round(($detailOrder['price'] * 80) / 100, 2),
            'discount_pizza' => null,
            'discount_potato' => $config['free_potato'],
        ];

        $infoBill = $this->service->handleDiscount($detailOrder);

        $this->assertEquals($expectedInfoBill, $infoBill);
    }
}
