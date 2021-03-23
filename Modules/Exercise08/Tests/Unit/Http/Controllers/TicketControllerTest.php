<?php

namespace Modules\Exercise08\Tests\Unit\Http\Controllers;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Modules\Exercise08\Services\TicketService;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Modules\Exercise08\Http\Controllers\TicketController;

class TicketControllerTest extends TestCase
{
    protected $monday;
    protected $controller;
    protected $ticketServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->ticketServiceMock = $this->createMock(TicketService::class);
        $this->controller = new TicketController($this->ticketServiceMock);
        $this->monday = Carbon::parse('first monday of this month')->format('m/d/Y');
    }

    public function test_view_index()
    {
        $view = $this->controller->index();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('exercise08::index', $view->name());
    }

    public function test_calculate()
    {
        $request = new CalculateRequest([
            'age' => 15,
            'gender' => 'male',
            'name' => 'My Name is Hieu',
            'booking_date' => $this->monday,
        ]);
        $price = TicketService::BASE_PRICE;
        $this->ticketServiceMock->expects($this->once())
             ->method('calculatePrice')
             ->willReturn($price);
        
        $result = $this->controller->calculatePrice($request);

        $this->assertTrue(Session::has('data_success'));
        $this->assertArrayHasKey('price', Session::get('data_success'));
        $this->assertArrayHasKey('name', Session::get('data_success'));
        $this->assertArrayHasKey('gender', Session::get('data_success'));
        $this->assertArrayHasKey('booking_date', Session::get('data_success'));
        $this->assertArrayHasKey('age', Session::get('data_success'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
