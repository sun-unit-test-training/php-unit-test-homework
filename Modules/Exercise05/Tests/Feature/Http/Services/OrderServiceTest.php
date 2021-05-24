<?php

namespace Modules\Tests\Exercise05\Tests\Http\Services;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class CalendarServiceTest extends TestCase
{
    private $orderService;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    /**
     * @dataProvider provideData
     */
    public function testHandleDiscount($detailOrder, $expectValue)
    {
        $response = $this->orderService->handleDiscount($detailOrder);
        //print_r($response);

        $this->assertEquals($response, $expectValue);
    }

    public function provideData()
    {
        return [
            [
                $this->makeData(1501, 1, 2),
                $this->makeBill(1501, 'Khuyến mại pizza thứ 2', 'Miễn phí khoai tây')
            ],
            [
                $this->makeData(1600, 2, 1),
                $this->makeBill(1280, null, 'Miễn phí khoai tây')
            ],
            [
                $this->makeData(1400, 2, 2),
                $this->makeBill(1400, null, null)
            ],
            [
                $this->makeData(1400, 1, 3),
                $this->makeBill(1400, 'Khuyến mại pizza thứ 2', null)
            ],
        ];
    }

    public function makeData($price = null, $optionReceive = null, $optionCoupon = null)
    {
        return [
            'price' => $price,
            'option_receive' => $optionReceive,
            'option_coupon' => $optionCoupon,
        ];
    }

    public function makeBill($price = null, $discountPizza = null, $discountCoupon = null)
    {
        return [
            'price' => $price,
            'discount_pizza' => $discountPizza,
            'discount_potato' => $discountCoupon,
        ];
    }
}
