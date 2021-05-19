<?php

namespace Modules\Exercise05\Tests\Feature\Http\Controllers;

use Illuminate\View\View;
use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class Exercise05ControllerTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    protected $orderServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderServiceMock = $this->mock(OrderService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test__contruct()
    {
        $controller = new Exercise05Controller($this->orderServiceMock);

        $this->assertInstanceOf(Exercise05Controller::class, $controller);
    }

    public function test_index()
    {
        $url = action([Exercise05Controller::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise05::index');
        $response->assertViewHasAll([
            'optionReceives',
            'optionCoupons',
        ]);
    }

    public function test_store()
    {
        $input = [
            'price' => 99,
            'option_receive' => 1,
            'option_coupon' => 1,
        ];

        $request = $this->mock(OrderRequest::class);
        $request->shouldReceive('only')
            ->once()
            ->with('price', 'option_receive', 'option_coupon')
            ->andReturn($input);

        $this->orderServiceMock->shouldReceive('handleDiscount')
            ->with($input)
            ->once()
            ->andReturn([]);

        $controller = new Exercise05Controller($this->orderServiceMock);

        $this->assertInstanceOf(View::class, $controller->store($request));
    }
}
