<?php

namespace Modules\Exercise05\Tests\Unit\Services;

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
     * @dataProvider handleDiscountData
     */
    public function testHandleDiscount($infoBill, $detailOrder)
    {
        $result = $this->service->handleDiscount($detailOrder);

        $this->assertEquals($result, $infoBill);
    }

    function handleDiscountData()
    {
        /*return [
            [
                [
                    'price' => 1200.8,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây' 
                ],
                [
                    'price' => 1501,
                    'option_receive' => 2,
                    'option_coupon' => 1
                ]
            ],
            [
                [
                    'price' => 1501,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây' 
                ],
                [
                    'price' => 1501,
                    'option_receive' => 2,
                    'option_coupon' => 2
                ]
            ],
            [
                [
                    'price' => 1501,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây' 
                ],
                [
                    'price' => 1501,
                    'option_receive' => 1,
                    'option_coupon' => 2
                ]
            ],
            [
                [
                    'price' => 1200,
                    'discount_pizza' => null,
                    'discount_potato' => null 
                ],
                [
                    'price' => 1500,
                    'option_receive' => 2,
                    'option_coupon' => 1
                ]
            ],

            [
                [
                    'price' => 1500,
                    'discount_pizza' => null,
                    'discount_potato' => null 
                ],
                [
                    'price' => 1500,
                    'option_receive' => 2,
                    'option_coupon' => 2
                ]
            ],
            [
                [
                    'price' => 1500,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => null 
                ],
                [
                    'price' => 1500,
                    'option_receive' => 1,
                    'option_coupon' => 1
                ]
            ],
        ];*/
        return [
            [
                [
                    'price' => 1599.2,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây'
                ],
                [
                    'price' => 1999,
                    'option_receive' => 2,
                    'option_coupon' => 1
                ]
            ],
            [
                [
                    'price' => 1506,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây'
                ],
                [
                    'price' => 1506,
                    'option_receive' => 2,
                    'option_coupon' => 2
                ]
            ],
            [
                [
                    'price' => 1501,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => 'Miễn phí khoai tây'
                ],
                [
                    'price' => 1501,
                    'option_receive' => 1,
                    'option_coupon' => 2
                ]
            ],
            [
                [
                    'price' => 869.89,
                    'discount_pizza' => null,
                    'discount_potato' => null
                ],
                [
                    'price' => 1087.36,
                    'option_receive' => 2,
                    'option_coupon' => 1
                ]
            ],
            [
                [
                    'price' => 1500,
                    'discount_pizza' => null,
                    'discount_potato' => null
                ],
                [
                    'price' => 1500,
                    'option_receive' => 2,
                    'option_coupon' => 2
                ]
            ],
            [
                [
                    'price' => 1000,
                    'discount_pizza' => 'Khuyến mại pizza thứ 2',
                    'discount_potato' => null
                ],
                [
                    'price' => 1000,
                    'option_receive' => 1,
                    'option_coupon' => 1
                ]
            ],
        ];
    }
}
