<?php

namespace Modules\Exercise08\Tests\Unit;

use Tests\TestCase;
use Modules\Exercise08\Http\Controllers\TicketController;
use Mockery as m;
use Modules\Exercise08\Services\TicketService;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use SessionHandler;
use Illuminate\Session\Store;

class TicketControllerTest extends TestCase
{
    protected $ticketController;
    protected $ticketService;

    public function setUp(): void
    {
        parent::setUp();

        $this->ticketService = $this->mock(TicketService::class)->makePartial();
        $this->ticketController = new TicketController($this->ticketService);
    }

    public function test_index()
    {
        $result = $this->ticketController->index();
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('exercise08::index', $result->getName());
    }

    public function test_calculate_price_fail()
    {
        $request =  $this->mock(CalculateRequest::class)->makePartial();

        $request->shouldReceive('only')->andReturn([
            'age' => '',
            'booking_date' => '',
            'gender' => '',
            'name' => '',
        ]);
        $this->ticketService->shouldReceive('calculatePrice')->andReturn(0);

        $result = $this->ticketController->calculatePrice($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_calculate_price()
    {
        $request = $this->mock(CalculateRequest::class)->makePartial();
        $request->shouldReceive('only')->andReturn([
            'age' => '',
            'booking_date' => '',
            'gender' => '',
            'name' => '',
        ]);

        $this->ticketService->shouldReceive('calculatePrice')->andReturn(1);
        Session::shouldReceive('flash')->andReturn(1);
        Session::shouldReceive('previousUrl')->andReturn();
        Session::shouldReceive('driver')->andReturn(new Store('test', new SessionHandler));

        $result = $this->ticketController->calculatePrice($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
