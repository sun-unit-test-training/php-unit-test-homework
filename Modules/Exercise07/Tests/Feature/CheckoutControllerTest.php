<?php

namespace Modules\Exercise07\Tests\Feature;

use Modules\Exercise07\Http\Controllers\CheckoutController;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    private $checkoutService;

    public function setUp(): void
    {
        parent::setUp();
        $this->checkoutService = $this->mock(CheckoutService::class);
    }

    public function test_show_index()
    {
        $url = action([CheckoutController::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise07::checkout.index');
        $response->assertSessionMissing('order');
    }


    private function invalidInputs($inputs)
    {
        $validInputs = [
            'amount' => 100,
        ];

        return array_filter(array_merge($validInputs, $inputs), function ($value) {
            return $value !== null;
        });
    }

    public function providerInvalidAmount()
    {
        return [
            'Amount is required' => ['amount', null],
            'Amount should be integer' => ['amount', 100.4],
            'Amount should be min 1' => ['amount', 0],
        ];
    }

    /**
     * @dataProvider providerInvalidAmount
     */
    public function test_store_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([CheckoutController::class, 'store']);

        $inputs = $this->invalidInputs([
            $inputKey => $inputValue,
        ]);

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    public function test_store_when_input_valid()
    {
        $url = action([CheckoutController::class, 'store']);

        $this->checkoutService->shouldReceive('calculateShippingFee')->andReturn(100);

        $inputs = ['amount'  => 100];
        $response = $this->post($url, $inputs);

        $response->assertSessionHasInput($inputs);
        $response->assertSessionHas('order');
    }
}
