<?php
declare(strict_types=1);

namespace Modules\Exercise07\Http\Controllers;

use Illuminate\View\View;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    protected $checkoutService;
    protected $checkoutController;
    protected function setUp(): void
    {
        parent::setUp(); //
        $this->checkoutService = new CheckoutService();
        $this->checkoutController = new CheckoutController($this->checkoutService);
    }

    public function testFunctionIndex()
    {
        $response = $this->checkoutController->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise07::checkout.index', $response->getName());
    }

    public function testValidateForm()
    {
        $url = action([CheckoutController::class, 'store']);

        // case amount not found
        $response = $this->post($url, ['amount' => '']);
        $response->assertSessionHasErrors('amount');
        $response->assertSessionMissing('order');

        // case amount not integer
        $response = $this->post($url, ['amount' => 'abc']);
        $response->assertSessionHasErrors('amount');
        $response->assertSessionMissing('order');

        // case amount less than 1
        $response = $this->post($url, ['amount' => 0]);
        $response->assertSessionHasErrors('amount');
        $response->assertSessionMissing('order');

        // case amount is valid
        $response = $this->post($url, ['amount' => 500]);
        $response->assertSessionDoesntHaveErrors('amount');
        $response->assertSessionHas('order');

    }

    public function testFunctionStore()
    {
        $request = [
            'amount' => 599,
            'shipping_express' => '',
            'premium_member' => ''
        ];

        $order = $this->checkoutService->calculateShippingFee($request);

        $this->assertEquals([
            'amount' => 599,
            'shipping_express' => '',
            'premium_member' => '',
            'shipping_fee' => 500
        ], $order);
    }
}
