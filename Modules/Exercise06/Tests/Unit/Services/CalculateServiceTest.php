<?php

namespace Modules\Exercise06\Tests\Unit\Services;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderService = new OrderService();
    }

    /**
     * @param $detailOrder
     * @param $expectedValue
     * @dataProvider provideDetailOrder
     * */
    public function test_handle_discount($detailOrder, $expectedValue)
    {
        $holidays = ['2021-05-19'];

        $class = $this->orderService->handleDiscount($detailOrder);
        $this->assertEquals($expectedValue, $class);
    }

    public function provideDetailOrder()
    {
        return [
            [
                [
                    'price' => 2000,
                    'option_receive' => 1,
                    'option_coupon' => 1,
                ],
                [
                    'price' => 2000,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
            [
                [
                    'price' => 2000,
                    'option_receive' => 2,
                    'option_coupon' => 1,
                ],
                [
                    'price' => 1600,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
            [
                [
                    'price' => 2000,
                    'option_receive' => 2,
                    'option_coupon' => 2,
                ],
                [
                    'price' => 2000,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
        ];
    }
}
