<?php

namespace Modules\Exercise05\Tests\Unit\Http\Controllers;

use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Services\OrderService;
use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Tests\TestCase;

class Exercise05ControllerTest extends TestCase
{
    protected $orderServiceMock;
    protected $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderServiceMock = $this->createMock(OrderService::class);
        $this->controller = new Exercise05Controller($this->orderServiceMock);
    }

    public function test_index()
    {
        $result = $this->controller->index();

        $this->assertSame('exercise05::index', $result->name());
        $this->assertArrayHasKey('optionReceives', $result->getData());
        $this->assertArrayHasKey('optionCoupons', $result->getData());
    }

    public function test_store_success()
    {
        $requestMock = $this->getMockBuilder(OrderRequest::class)
            ->onlyMethods(['only'])
            ->getMock();
        $requestMock->expects($this->once())
            ->method('only')
            ->willReturn([
                'price' => 2000,
                'option_receive' => 2,
                'option_coupon' => 1,
            ]);
        $this->orderServiceMock->expects($this->once())
            ->method('handleDiscount')
            ->willReturn([
                'infoBuild' => [
                    'price' => 1600.00,
                    'discount_pizza' => null,
                    'discount_potato' => 'Miễn phí khoai tây',
                ]
            ]);

        $result = $this->controller->store($requestMock);

        $this->assertSame('exercise05::detail', $result->name());
        $this->assertArrayHasKey('resultOrder', $result->getData());
        $this->assertArrayHasKey('detailOrder', $result->getData());
    }
}
