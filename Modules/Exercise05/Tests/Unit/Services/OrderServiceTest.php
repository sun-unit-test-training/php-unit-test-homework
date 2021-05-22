<?php

namespace Tests\Unit\Services;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setup();

        $this->service = new OrderService();
    }

    /**
     * @dataProvider provide_detail_order_data
     * @param $detailOrder
     * @param $expected
     */
    public function test_handle_discount($detailOrder, $expected)
    {
        $response = $this->service->handleDiscount($detailOrder);

        $this->assertEquals($expected, $response);
    }

    public function provide_detail_order_data()
    {
        return [
            [
                [
                    'price' => 1000,
                    'option_receive' => 2,
                    'option_coupon' => 1
                ],
                [
                    'price' => 800,
                    'discount_pizza' => null,
                    'discount_potato' => null
                ],
            ],
            [
                [
                    'price' => 10000,
                    'option_receive' => 2,
                    'option_coupon' => 2,
                ],
                [
                    'price' => 10000,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
            [
                [
                    'price' => 10000,
                    'option_receive' => 2,
                    'option_coupon' => 1,
                ],
                [
                    'price' => 8000,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
            [
                [
                    'price' => 10000,
                    'option_receive' => 1,
                    'option_coupon' => 1,
                ],
                [
                    'price' => 10000,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ],
        ];
    }
}
