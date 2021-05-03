<?php

namespace Modules\Exercise07\Tests;

use Modules\Exercise07\Http\Controllers\CheckoutController;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;
use Mockery;

class CheckoutControllerTest extends TestCase
{
    public function test__construct()
    {
        $service = Mockery::mock(CheckoutService::class);
        $controller = new CheckoutController($service);
        $serviceRef = $this->getHiddenProperty($controller, 'checkoutService');
        $this->assertSame($service, $serviceRef->getValue($controller));
    }

    public function test_index()
    {
        $response = $this->get(action([CheckoutController::class, 'index']));
        $response->assertStatus(200);
        $response->assertViewIs('exercise07::checkout.index');

    }

    public function test_store_success()
    {
        $response = $this->post(action([CheckoutController::class, 'store']), [
            'amount' => 1102,
        ]);

        $response->assertStatus(302);
        $this->assertTrue($response->isRedirection());
        $response->assertSessionHas('order');
        $response->assertSessionHas('_old_input');
    }

    /**
     * @dataProvider input_store_error
     * @param $input
     */
    public function test_store_error($input)
    {
        $response = $this->post(action([CheckoutController::class, 'store']), $input);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('amount');
        $this->assertTrue($response->isRedirection());
    }

    public function input_store_error()
    {
        return [
            [
                [
                    'amount' => 'is not numeric',
                ]
            ],
            [
                [
                    'amount' => -1102,
                ]
            ],
            [
                [
                    'amount' => 0,
                ]
            ],
            [
                []
            ],
        ];
    }
}
