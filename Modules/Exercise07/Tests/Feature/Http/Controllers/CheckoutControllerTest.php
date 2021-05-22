<?php

namespace Modules\Exercise07\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise07\Http\Controllers\CheckoutController as Exercise;
use Modules\Exercise07\Services\CheckoutService;
use Tests\SetupDatabaseTrait;
use Modules\Exercise07\Constants\Checkout;

class CheckoutControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $serviceMock;
    protected $controllerMethod;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->serviceMock = $this->mock(CheckoutService::class);
        $this->controllerMethod = 'store';
    }

    function test_index()
    {
        $url = action([Exercise::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise07::checkout.index');

    }

    /**
     * @dataProvider provideWrongAmount
     */
    function test_it_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([Exercise::class, $this->controllerMethod]);
        $inputs = [$inputKey => $inputValue];

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    function provideWrongAmount()
    {
        return [
            'Amount is missing' => [null, null],
            'Amount is null' => ['amount', null],
            'Amount is not integer' => ['amount', 'not_integer'],
            'Amount minimum is less than one' => ['amount', 0],
        ];
    }

    function test_store_success()
    {
        $dummyOrder = [
            'amount' => Checkout::FREE_SHIPPING_AMOUNT - 1,
            'premium_member' => '',
            'shipping_express' => 'shipping_express_example',
        ];

        $this->serviceMock
            ->shouldReceive('calculateShippingFee')
            ->andReturn($dummyOrder);

        $url = action([Exercise::class, $this->controllerMethod]);

        $response = $this->post($url, $dummyOrder);

        $response->assertSessionDoesntHaveErrors(['amount']);
        $response->assertSessionHasInput(['amount']);
        $response->assertSessionHas('order', function ($order) use ($dummyOrder) {
            return $order == $dummyOrder;
        });
    }
}
