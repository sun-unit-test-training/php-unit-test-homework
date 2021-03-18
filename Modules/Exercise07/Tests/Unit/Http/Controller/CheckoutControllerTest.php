<?php

    namespace Modules\Exercise07\Tests\Unit\Http\Controller;

    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Session;
    use Tests\TestCase;
    use Modules\Exercise07\Http\Requests\CheckoutRequest;
    use Modules\Exercise07\Http\Controllers\CheckoutController;
    use Modules\Exercise07\Services\CheckoutService;

    class CheckoutControllerTest extends TestCase
    {
        protected $checkoutServiceMock;
        protected $checkoutController;

        public function setUp(): void
        {
            parent::setUp();
            $this->checkoutServiceMock = $this->createMock(CheckoutService::class);
            $this->checkoutController = new CheckoutController($this->checkoutServiceMock);
        }

        public function test_index()
        {
            $view = $this->checkoutController->index();
            $this->assertSame('exercise07::checkout.index', $view->getName());
        }

        public function test_create_success()
        {

            $request = [
                'amount' => 1
            ];
            $requestMock = new CheckoutRequest($request);
            $orderMock = $this->getMockBuilder(Order::class);
            $this->checkoutServiceMock->expects($this->once())
                ->method('calculateShippingFee')
                ->willReturn($orderMock);
            $result = $this->checkoutController->store($requestMock);

            $this->assertInstanceOf(RedirectResponse::class, $result);
            $this->assertTrue(Session::has('order'));
        }

    }
