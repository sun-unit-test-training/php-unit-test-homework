<?php

namespace Modules\Exercise05\Tests;

use Modules\Exercise05\Services\OrderService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new OrderService();
    }

    /**
     * @dataProvider caseForTest
     * @param $price
     * @param $optionReceive
     * @param $optionCoupon
     * @param $result
     */
    public function testHandleDiscount($price, $optionReceive, $optionCoupon, $result)
    {
        $detailOrder = [
            'price' => $price,
            'option_receive' => $optionReceive,
            'option_coupon' => $optionCoupon,
        ];
        $infoBill = $this->service->handleDiscount($detailOrder);

        $this->assertEquals($result, $infoBill);
    }

    public function caseForTest()
    {
        return [
            [
                1600,
                2,
                1,
                [
                    'price' => 1280.0,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ],
            ],
            [
                1600,
                3,
                1,
                [
                    'price' => 1600,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây',
                ],
            ],
        ];
    }
}