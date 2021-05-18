<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected $calendarServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new OrderService();
    }

    /**
     * @dataProvider provider_test_handle_discount
     */
    public function test_handle_discount($detailOrder, $discount)
    {
        $result = $this->service->handleDiscount($detailOrder);

        $this->assertEquals($discount, $result);
    }

    public function provider_test_handle_discount()
    {
        return [
            [
                [
                    'price' => 1000,
                    'option_receive' => '1',
                    'option_coupon' => '1',
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
                    'option_receive' => '2',
                    'option_coupon' => '1',
                ],
                [
                    'price' => 800,
                    'discount_pizza' => null,
                    'discount_potato' => null,
                ],
            ],
            [
                [
                    'price' => 1000,
                    'option_receive' => '1',
                    'option_coupon' => '2',
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
                    'option_receive' => '2',
                    'option_coupon' => '2',
                ],
                [
                    'price' => 1000,
                    'discount_pizza' => null,
                    'discount_potato' => null,
                ],
            ],
            [
                [
                    'price' => 1600,
                    'option_receive' => '1',
                    'option_coupon' => '2',
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
                    'option_receive' => '2',
                    'option_coupon' => '1',
                ],
                [
                    'price' => 1280,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ],
            ],
            [
                [
                    'price' => 1600,
                    'option_receive' => '1',
                    'option_coupon' => '1',
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
                    'option_receive' => '2',
                    'option_coupon' => '2',
                ],
                [
                    'price' => 1600,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ],
            ],
        ];
    }
}
