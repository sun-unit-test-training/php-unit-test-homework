<?php

namespace Modules\Exercise05\Tests;

use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;
use Mockery;

class Exercise05ControllerTest extends TestCase
{
    public function test__construct()
    {
        $service = Mockery::mock(OrderService::class);
        $controller = new Exercise05Controller($service);
        $repositoryRef = $this->getHiddenProperty($controller, 'orderService');
        $this->assertSame($service, $repositoryRef->getValue($controller));
    }

    public function test_index()
    {
        $response = $this->get(action([Exercise05Controller::class, 'index']));
        $response->assertStatus(200);
        $response->assertViewIs('exercise05::index');

        $optionReceives = $response->viewData('optionReceives');
        $this->assertEquals([
            '2' => 'Nhận tại nhà',
            '1' => 'Nhận tại cửa hàng',
        ], $optionReceives);

        $optionCoupons = $response->viewData('optionCoupons');
        $this->assertEquals([
            '2' => 'Không',
            '1' => 'Có',
        ], $optionCoupons);
    }

    public function test_store_success()
    {
        $response = $this->post(action([Exercise05Controller::class, 'store']), [
            'price' => 1102,
            'option_receive' => 1,
            'option_coupon' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('exercise05::detail');

        $resultOrder = $response->viewData('resultOrder');
        $this->assertEquals([
            'price' => 1102,
            'discount_pizza' => 'Khuyến mại pizza thứ 2',
            'discount_potato' => null,
        ], $resultOrder);

        $detailOrder = $response->viewData('detailOrder');
        $this->assertEquals([
            'price' => 1102,
            'option_receive' => 1,
            'option_coupon' => 1,
        ], $detailOrder);
    }

    /**
     * @dataProvider input_store_error
     * @param $input
     * @param $responseError
     */
    public function test_store_error($input, $responseError)
    {
        $response = $this->post(action([Exercise05Controller::class, 'store']), $input);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($responseError);
        $this->assertTrue($response->isRedirection());
    }

    public function input_store_error()
    {
        return [
            [
                [
                    'price' => 1111,
                    'option_receive' => 11,
                    'option_coupon' => 11,
                ], [
                    'option_receive',
                    'option_coupon',
                ],
            ],
            [
                [
                    'price' => 'is not numeric',
                    'option_receive' => 1,
                    'option_coupon' => 1,
                ], [
                    'price',
                ],
            ],
            [
                [
                    'price' => 1111,
                    'option_receive' => 2,
                    'option_coupon' => 11,
                ], [
                    'option_coupon',
                ],
            ],
            [
                [
                    'price' => 1111,
                    'option_receive' => 11,
                    'option_coupon' => 2,
                ], [
                    'option_receive',
                ],
            ],
        ];
    }
}
