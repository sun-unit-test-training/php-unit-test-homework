<?php
namespace App\Modules\Exercise05\Tests\Services;

use Mockery;
use Tests\TestCase;
use Modules\Exercise05\Services\OrderService;
use Illuminate\Support\Carbon;

class OrderServiceTest extends TestCase
{

    /**
     * @dataProvider providerTestHandleDiscount
     */
    public function testHandleDiscount($input, $expect)
    {
        $service = new OrderService;
        $response = $service->handleDiscount($input);

        $this->assertEquals($expect['price'], $response['price']);
        $this->assertEquals($expect['discount_pizza'], $response['discount_pizza']);
        $this->assertEquals($expect['discount_potato'], $response['discount_potato']);
    }

    public function providerTestHandleDiscount()
    {
        return [
            [
                [
                    'price' => 1500,
                    'option_receive' => '2',
                    'option_coupon' => '1',
                ],
                [
                    'price' => 1200,
                    'discount_pizza' => null,
                    'discount_potato' => null,
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
        ];
    }
}
