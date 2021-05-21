<?php

namespace Tests\Unit\Services;

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
        return [
            [
                [
                    'price' => 500,
                    'option_receive' => 2,
                    'option_coupon' => 2
                ],
                [
                    'price' => 500,
                    'discount_pizza' => null,
                    'discount_potato' => null
                ],
            ],
            [
                [
                    'price' => 500,
                    'option_receive' => 1,
                    'option_coupon' => 2
                ],
                [
                    'price' => 500,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => null
                ],
            ],

            [
                [
                    'price' => 500,
                    'option_receive' => 2,
                    'option_coupon' => 1
                ],
                [
                    'price' => round((500 * 80) / 100, 2),
                    'discount_pizza' => null,
                    'discount_potato' => null
                ],
            ],
            [
                [
                    'price' => 2000,
                    'option_receive' => 1,
                    'option_coupon' => 2
                ],
                [
                    'price' => 2000,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây'
                ],
            ],
            [
                [
                    'price' => 2000,
                    'option_receive' => 2,
                    'option_coupon' => 2
                ],
                [
                    'price' => 2000,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây'
                ],
            ],
            [
                [
                    'price' => 2000,
                    'option_receive' => 2,
                    'option_coupon' => 1
                ],
                [
                    'price' => round((2000 * 80) / 100, 2),
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây'
                ],
            ],
        ];
    }
}