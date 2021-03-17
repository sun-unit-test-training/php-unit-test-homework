<?php

namespace Modules\Exercise01\Tests\Unit\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Modules\Exercise01\Http\Controllers\OrderController;
use Modules\Exercise01\Http\Requests\OrderRequest;
use Modules\Exercise01\Services\DTO\Price;
use Modules\Exercise01\Services\PriceService;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    protected $priceServiceMock;
    protected $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->priceServiceMock = $this->createMock(PriceService::class);
        $this->controller = new OrderController($this->priceServiceMock);
    }

    public function test_show_form()
    {
        $result = $this->controller->showForm();
        $this->assertSame('exercise01::order', $result->name());
        $this->assertArrayHasKey('unitPrice', $result->getData());
        $this->assertArrayHasKey('voucherUnitPrice', $result->getData());
        $this->assertArrayHasKey('specialTimeUnitPrice', $result->getData());
        $this->assertArrayHasKey('specialTimePeriod', $result->getData());
    }

    public function test_create_success()
    {
        $requestMock = $this->getMockBuilder(OrderRequest::class)
            ->onlyMethods(['validated'])
            ->getMock();
        $requestMock->expects($this->once())
            ->method('validated')
            ->willReturn([
                'quantity' => 1,
                'voucher' => true,
            ]);
        $priceMock = $this->getMockBuilder(Price::class);
        $this->priceServiceMock->expects($this->once())
            ->method('calculate')
            ->willReturn($priceMock);

        $result = $this->controller->create($requestMock);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertTrue(Session::has('order'));
        $this->assertArrayHasKey('quantity', Session::get('order'));
        $this->assertArrayHasKey('price', Session::get('order'));
    }
}
