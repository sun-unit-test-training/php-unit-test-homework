<?php

namespace Modules\Exercise05\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise05\Http\Controllers\Exercise05Controller as Exercise;
use Modules\Exercise05\Services\OrderService;
use Modules\Exercise05\Http\Requests\OrderRequest;


class Exercise05ControllerTest extends TestCase
{

    protected $serviceMock;
    protected $controllerMethod;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->serviceMock = $this->mock(OrderService::class);
        $this->controllerMethod = 'store';
    }

    function test_index()
    {
        $expectedReceives = config('exercise05.option_receive');
        $expectedCoupons = config('exercise05.option_coupon');

        $url = action([Exercise::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise05::index');
        $response->assertViewHasAll([
            'optionReceives',
            'optionCoupons',
        ]);

        $this->assertEquals($expectedReceives, $response->viewData('optionReceives'));
        $this->assertEquals($expectedCoupons, $response->viewData('optionCoupons'));
    }

    /**
     * @dataProvider provideWrongInput
     */
    function test_store_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([Exercise::class, $this->controllerMethod]);

        $response = $this->post($url, $inputValue);

        $response->assertSessionHasErrors([$inputKey]);
    }

    function provideWrongInput()
    {
        return [
            'missing_price' => [
                'price',
                [
                    'option_receive' => 1,
                    'option_coupon' => 1,
                ]
            ],
            'missing_option_receive' => [
                'option_receive',
                [
                    'price' => 1,
                    'option_coupon' => 1,
                ]
            ],
            'missing_option_coupon' => [
                'option_coupon',
                [
                    'price' => 1,
                    'option_receive' => 1,
                ]
            ],
            'price_not_numeric' => [
                'price',
                [
                    'price' => 'price',
                    'option_coupon' => 1,
                    'option_receive' => 1,
                ]
            ],
            'invalid_option_receive' => [
                'option_receive',
                [
                    'price' => 1,
                    'option_coupon' => 1,
                    'option_receive' => 100,
                ]
            ],
            'invalid_option_coupon' => [
                'option_coupon',
                [
                    'price' => 1,
                    'option_coupon' => 100,
                    'option_receive' => 1,
                ]
            ],
        ];
    }

    function test_store_success()
    {
        $detailOrder = [
            'price' => 1,
            'option_receive' => config('exercise05.receive_at_store'),
            'option_coupon' => config('exercise05.no_coupon'),
        ];

        $url = action([Exercise::class, $this->controllerMethod]);

        $mockRequest = $this->mock(OrderRequest::class);
        $mockRequest->shouldReceive('only')->andReturn($detailOrder);

        $this->serviceMock
            ->shouldReceive('handleDiscount')
            ->with($detailOrder)
            ->andReturn([]);

        $response = $this->post($url, $detailOrder);

        // dd($response->dump());

        // $response->assertOk();
        // $response->assertViewIs('exercise05::detail');

        $response->assertSessionHas('resultOrder', function ($resultOrder) {
            return $resultOrder == [];
        });
    }
}
