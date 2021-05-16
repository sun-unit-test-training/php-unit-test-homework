<?php

namespace Modules\Exercise07\Tests\Unit\Controllers;

use Modules\Exercise07\Http\Controllers\CheckoutController;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    public function test_index()
    {
        $checkoutService = $this->mock(CheckoutService::class);
        $controller = new CheckoutController($checkoutService);

        $result = $controller->index();

        $this->assertEquals('exercise07::checkout.index', $result->name());
    }

    public function test_store_success()
    {
        $response = $this->post(action([CheckoutController::class, 'store']), [
            'amount' => 10,
        ]);

        $response->assertStatus(302);
        $this->assertTrue($response->isRedirection());
        $response->assertSessionHas('order');
        $response->assertSessionHas('_old_input');
    }

    /**
     * @param $input
     * @dataProvider invalid_input_data
     */
    public function test_calculate_with_invalid_input($input)
    {
        $response = $this->post(action([CheckoutController::class, 'store']), $input);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('amount');
        $this->assertTrue($response->isRedirection());
    }

    public function invalid_input_data()
    {
        return [
            [
                []
            ],
            [
                [
                    'amount' => 'a',
                ]
            ],
            [
                [
                    'amount' => '-1',
                ]
            ],
        ];
    }
}
