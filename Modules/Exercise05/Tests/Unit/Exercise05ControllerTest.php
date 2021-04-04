<?php

namespace Modules\Exercise05\Tests\Unit;

use Mockery;
use Tests\TestCase;
use Illuminate\View\View;
use Modules\Exercise05\Services\OrderService;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Http\Controllers\Exercise05Controller;

/**
 * Class Exercise05ControllerTest
 */
class Exercise05ControllerTest extends TestCase
{
    /**
     * Store a new resource success
     *
     * @test
     *
     * @return void
     */
    public function store_new_resource_success()
    {
        $request = new OrderRequest();
        $mockService = Mockery::mock(OrderService::class)->makePartial();
        $excController = new Exercise05Controller($mockService);

        $mockService->shouldReceive('handleDiscount')
            ->with($request->all())
            ->once()
            ->andReturn(200);

        $response = $excController->store($request);

        $this->assertInstanceOf(View::class, $response);
    }
}
