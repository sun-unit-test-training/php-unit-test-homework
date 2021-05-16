<?php

namespace Modules\Exercise05\Tests\Unit\Controllers;

use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;
use Mockery\MockInterface;

class Exercise05ControllerTest extends TestCase
{
    public function test_index_success()
    {
        $response = $this->get(action([Exercise05Controller::class, 'index']));

        $response->assertStatus(200);
        $response->assertViewIs('exercise05::index');

        $optionReceives = $response->viewData('optionReceives');
        $optionCoupons = $response->viewData('optionCoupons');

        $this->assertEquals(config('exercise05.option_receive'), $optionReceives);
        $this->assertEquals(config('exercise05.option_coupon'), $optionCoupons);
    }

    public function test_store_success()
    {
        $orderService = $this->mock(OrderService::class, function (MockInterface $mock) {
            $mock->shouldReceive('handleDiscount')
                ->once()
                ->andReturn(100);
        });

        $controller = new Exercise05Controller($orderService);
        $request = new OrderRequest([
            'price' => 100,
            'option_receive' => 1,
            'option_coupon' => 2,
        ]);

        $view = $controller->store($request);

        $this->assertEquals('exercise05::detail', $view->name());
    }

    /**
     * @param $input
     * @param $errorField
     * @dataProvider error_validation_data
     */
    public function test_store_invalid_valitation($input, $errorField)
    {
        $response = $this->post(action([Exercise05Controller::class, 'store']), $input);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($errorField);
        $this->assertTrue($response->isRedirection());
    }

    public function error_validation_data()
    {
        return [
            [
                [],
                [
                    'price',
                    'option_receive',
                    'option_coupon',
                ],
            ],
            [
                [
                    'price' => 100,
                ],
                [
                    'option_receive',
                    'option_coupon',
                ],
            ],
            [
                [
                    'price' => 100,
                    'option_receive' => 5,
                    'option_coupon' => 5,
                ],
                [
                    'option_receive',
                    'option_coupon',
                ],
            ]
        ];
    }
}
