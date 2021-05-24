<?php

namespace Modules\Exercise05\Tests\Unit\Services;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    /**
     * @param $input
     * @param $expected
     * @dataProvider donotReceiveAtHomeAndHaveCoupon
     * @dataProvider receiveAtHomeAndNoCoupon
     * @dataProvider priceLessThanDiscountPotato
     */
    public function test_handle_discount_function($input, $expected)
    {
        $orderService = new OrderService();
        $result = $orderService->handleDiscount($input);

        $this->assertEquals($expected, $result);
    }

    public function donotReceiveAtHomeAndHaveCoupon()
    {
        return [
            [
                [
                    'price' => '2000',
                    'option_receive' => 0,
                    'option_coupon' => 2
                ],
                [
                    'price' => '2000',
                    'discount_potato' => 'Miễn phí khoai tây',
                    'discount_pizza' => 'Khuyến mại pizza thứ 2'
                ]
            ],
        ];
    }

    public function receiveAtHomeAndNoCoupon()
    {
        return [
            [
                [
                    'price' => '2000',
                    'option_receive' => 2,
                    'option_coupon' => 1
                ],
                [
                    'price' => '1600',
                    'discount_potato' => 'Miễn phí khoai tây',
                    'discount_pizza' => null
                ]
            ]
        ];
    }

    public function priceLessThanDiscountPotato()
    {
        return [
            [
                [
                    'price' => '1000',
                    'option_receive' => 2,
                    'option_coupon' => 1
                ],
                [
                    'price' => '800',
                    'discount_potato' => null,
                    'discount_pizza' => null
                ]
            ]
        ];
    }
}
