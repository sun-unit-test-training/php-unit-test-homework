<?php

namespace Tests\Unit;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected $orderService;

    protected function setUp(): void
    {
        parent::setup();

        $this->orderService = new OrderService();
    }

    /**
     * @dataProvider provider_input_discount
     */
    public function test_handlde_discount($detailOrder, $infoBill)
    {
        $result = $this->orderService->handleDiscount($detailOrder);

        $this->assertEquals($result, $infoBill);
    }

    public function provider_input_discount(): array
    {
        //1: at store
        //2: no coupon
        return [
            [
                [
                    'price' => 1000,
                    'option_receive' => 1,
                    'option_coupon' => 2,
                ],
                [
                    'price' => 1000,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => null,
                ],
            ],
            [
                [
                    'price' => 1000,
                    'option_receive' => 2,
                    'option_coupon' => 2,
                ],
                [
                    'price' => 1000,
                    'discount_pizza' => null,
                    'discount_potato' => null,
                ],
            ],

            [
                [
                    'price' => 1000,
                    'option_receive' => 2,
                    'option_coupon' => 1,
                ],
                [
                    'price' => 800,
                    'discount_pizza' => null,
                    'discount_potato' => null,
                ],
            ],
            [
                [
                    'price' => 1600,
                    'option_receive' => 2,
                    'option_coupon' => 2,
                ],
                [
                    'price' => 1600,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ],
            ],
            [
                [
                    'price' => 1600,
                    'option_receive' => 1,
                    'option_coupon' => 2,
                ],
                [
                    'price' => 1600,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây',
                ],
            ],
            [
                [
                    'price' => 1600,
                    'option_receive' => 2,
                    'option_coupon' => 1,
                ],
                [
                    'price' => 1280,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ],
            ],
        ];
    }
}