<?php

namespace Modules\Exercise05\Tests\Feature\Http\Controllers;

use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;
use Tests\SetupDatabaseTrait;

class Exercise05ControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->mock(OrderService::class);
    }

    public function testIndex()
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

    public function testStore()
    {
        $input = [
            'price' => 1506,
            'option_receive' => '1',
            'option_coupon' => '2',
        ];

        $result = [
            'price' => 1506,
            'discount_pizza' => 'Khuyến mại pizza thứ 2',
            'discount_potato' => 'Miễn phí khoai tây',
        ];

        $url = action([Exercise05Controller::class, 'store']);

        $this->service->shouldReceive('handleDiscount')
            ->with($input)
            ->andReturn($result);

        $response = $this->post($url, $input);

        $response->assertViewIs('exercise05::detail');
        $response->assertViewHasAll([
            'resultOrder',
            'detailOrder'
        ]);
    }

    /**
     * @dataProvider inputStoreError
     * @param $input
     * @param $responseError
     */
    public function testStoreError($input, $responseError)
    {
        $response = $this->post(action([Exercise05Controller::class, 'store']), $input);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($responseError);
        $this->assertTrue($response->isRedirection());
    }

    public function inputStoreError()
    {
        return [
            [
                [
                    'price' => 'test',
                    'option_receive' => 1,
                    'option_coupon' => 2
                ],
                'price'
            ],
            [
                [
                    'price' => 1000,
                    'option_receive' => 123,
                    'option_coupon' => 1
                ],
                'option_receive'
            ],
            [
                [
                    'price' => 999,
                    'option_receive' => 1,
                    'option_coupon' => 3
                ],
                'option_coupon'
            ],
        ];
    }
}