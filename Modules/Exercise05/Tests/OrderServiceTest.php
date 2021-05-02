<?php

namespace Modules\Exercise05\Tests;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    /**
     * @dataProvider detail_order_input
     * @param $detailOrder
     * @param $expectedResult
     */
    public function test_handle_discount($detailOrder, $expectedResult)
    {
        $service = new OrderService();
        $result = $service->handleDiscount($detailOrder);
        $this->assertEquals($expectedResult, $result);
    }

    public function detail_order_input()
    {
        return [
            [
                [
                    'price' => 1600,
                    'option_receive' => 2,
                    'option_coupon' => 1,
                ], [
                    'price' => 1280.0,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
            [
                [
                    'price' => 1600,
                    'option_receive' => 2,
                    'option_coupon' => 2,
                ], [
                    'price' => 1600,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
            [
                [
                    'price' => 1600,
                    'option_receive' => 1,
                    'option_coupon' => 2,
                ], [
                    'price' => 1600,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
            [
                [
                    'price' => 1500,
                    'option_receive' => 1,
                    'option_coupon' => 2,
                ], [
                    'price' => 1500,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => null,
                ]
            ],
        ];
    }
}
