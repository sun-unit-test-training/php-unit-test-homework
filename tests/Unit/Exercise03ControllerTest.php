<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Contracts\View\View;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Http\Controllers\ProductController;

class Exercise03ControllerTest extends TestCase
{
    protected $controller;
    protected $productServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->productServiceMock = $this->createMock(ProductService::class);
        $this->controller = new ProductController($this->productServiceMock);
    }

    public function test_index()
    {
        $view = $this->controller->index();
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('exercise03::index', $view->name());
        $this->assertArrayHasKey('products', $view->getData());
    }

    public function test_checkout()
    {
        $checkoutRequestMock = $this->getMockBuilder(CheckoutRequest::class)->getMock();
        $result = $this->controller->checkout($checkoutRequestMock);

        $this->assertArrayHasKey('discount', (array)json_decode($result->content()));
        $this->assertEquals(200, $result->getStatusCode());
    }
}
