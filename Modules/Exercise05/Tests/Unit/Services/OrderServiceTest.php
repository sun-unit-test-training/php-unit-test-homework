<?php

namespace Modules\Exercise05\Tests\Services;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;
class OrderServiceTest extends TestCase
{
    protected $service;

    public function setup(): void
    {
        parent::setUp();
        $this->service = new OrderService;
    }

    public function test_case_1()
    {
        $inputs = [
            'price' => 1500,
            'option_receive' => 1, //store
            'option_coupon' => 2, //no coupon
        ];

        $expects = [
            'price' => 1500,
            'discount_pizza' => 'Khuyến mại pizza thứ 2',
            'discount_potato' => null,
        ];
        $result = $this->service->handleDiscount($inputs);

        $this->assertSame($expects, $result);
    }

    public function test_case_2()
    {
        $inputs = [
            'price' => 1501,
            'option_receive' => 2, //home
            'option_coupon' => 1, //coupon
        ];

        $expects = [
            'price' => 1200.8,
            'discount_pizza' => null,
            'discount_potato' => 'Miễn phí khoai tây',
        ];
        $result = $this->service->handleDiscount($inputs);

        $this->assertSame($expects, $result);
    }

    public function test_case_3()
    {
        $inputs = [
            'price' => 2000,
            'option_receive' => 1, //store
            'option_coupon' => 1, //coupon
        ];

        $expects = [
            'price' => 2000,
            'discount_pizza' => 'Khuyến mại pizza thứ 2',
            'discount_potato' => 'Miễn phí khoai tây',
        ];
        $result = $this->service->handleDiscount($inputs);
  
        $this->assertSame($expects, $result);
    }

    public function test_case_4()
    {
        $inputs = [
            'price' => 1499,
            'option_receive' => 2, //home
            'option_coupon' => 2, //coupon
        ];

        $expects = [
            'price' => 1499,
            'discount_pizza' => null,
            'discount_potato' => null,
        ];
        $result = $this->service->handleDiscount($inputs);

        $this->assertSame($expects, $result);
    }
}