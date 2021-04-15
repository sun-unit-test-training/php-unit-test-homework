<?php
namespace Modules\Exercise03\Tests\Http\Requests;

use Mockery;
use Tests\TestCase;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Http\Controllers\ProductController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\View;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Illuminate\Http\JsonResponse;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;

class ProductControllerTest extends TestCase
{
    public function testConstruct()
    {
        $product = new Product;
        $repository = new ProductRepository($product);
        $service = new ProductService($repository);
        $controller = new ProductController($service);

        $this->assertInstanceOf(ProductController::class, $controller);
    }

    public function testIndex()
    {
        $collection = Mockery::mock(Collection::class);

        $service = Mockery::mock(ProductService::class);
        $service->shouldReceive('getAllProducts')->once()->andReturn($collection);

        $controller = new ProductController($service);

        $this->assertInstanceOf(View::class, $controller->index());
    }

    public function testCheckout()
    {
        $input = [
            1 => 1,
            2 => 2,
            3 => 3,
        ];
        $response = 5;

        $request = Mockery::mock(CheckoutRequest::class);
        $request->shouldReceive('input')->once()->with('total_products')->andReturn($input);

        $service = Mockery::mock(ProductService::class);
        $service->shouldReceive('calculateDiscount')->once()->with($input)->andReturn($response);

        $controller = new ProductController($service);

        $this->assertInstanceOf(JsonResponse::class, $controller->checkout($request));
    }
}
