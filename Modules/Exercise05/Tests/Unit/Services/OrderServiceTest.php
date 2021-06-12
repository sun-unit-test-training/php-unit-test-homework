<?php

namespace Modules\Exercise05\Tests\Unit\Services;

use Modules\Exercise05\Services\OrderService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $orderService;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    /**
     * @dataProvider provideDetailOrder
     */
    public function test_it_handle_discount($infoBill, $detailOrder)
    {
        $result = $this->orderService->handleDiscount($detailOrder);

        $this->assertEquals($result, $infoBill);
    }

    function provideDetailOrder()
    {
        return [
            'Has Discount Potato and Coupon Applied' => [
                [
                    'price' => 1200.8,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây' 
                ],
                [
                    'price' => 1501,
                    'option_receive' => 2, //at home
                    'option_coupon' => 1 //has coupon
                ]
            ],
            'Has Discount Potato and No Coupon Applied' => [
                [
                    'price' => 1501,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây' 
                ],
                [
                    'price' => 1501,
                    'option_receive' => 2, //at home
                    'option_coupon' => 2 //no coupon
                ]
            ],
            'Has Discount Potato and Pizza' => [
                [
                    'price' => 1501,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây' 
                ],
                [
                    'price' => 1501,
                    'option_receive' => 1, //at store
                    'option_coupon' => 2 //no coupon
                ]
            ],
            'Has No Discount Potato and Coupon Applied' => [
                [
                    'price' => 1200,
                    'discount_pizza' => null,
                    'discount_potato' => null 
                ],
                [
                    'price' => 1500,
                    'option_receive' => 2, //at home
                    'option_coupon' => 1 // has coupon
                ]
            ],

            'Has No Discount Potato and No Cupon Applied' => [
                [
                    'price' => 1500,
                    'discount_pizza' => null,
                    'discount_potato' => null 
                ],
                [
                    'price' => 1500,
                    'option_receive' => 2, //at home
                    'option_coupon' => 2 //no coupon
                ]
            ],
            'Has Discount Pizza and No Discount Patato' => [
                [
                    'price' => 1500,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => null 
                ],
                [
                    'price' => 1500,
                    'option_receive' => 1, //at store
                    'option_coupon' => 1 //has coupon
                ]
            ],
            'Rounded Value of Price To Precision 2' => [
                [
                    'price' => 1501.43,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây' 
                ],
                [
                    'price' => 1876.78875,
                    'option_receive' => 2, //at home
                    'option_coupon' => 1 //has coupon
                ]
            ]
        ];
    }
}
