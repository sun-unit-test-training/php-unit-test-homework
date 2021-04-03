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
    protected $ticketServiceMock;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->ticketServiceMock = $this->createMock(TicketService::class);
        $this->controller = new TicketController($this->ticketServiceMock);
    }

    public function test_index()
    {
        $view = $this->controller->index();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('exercise08::index', $view->name());
    }

    public function test_calculate_price()
    {
        $requestMock = $this->getMockBuilder(CalculateRequest::class)
            ->onlyMethods(['only'])
            ->getMock();
        $requestMock->expects($this->once())
            ->method('only')
            ->willReturn([
                'name' => 'Quan',
                'age' => 21,
                'gender' => 'male',
                'booking_date' => Carbon::now()->format('m/d/Y'),
            ]);

        $price = TicketService::BASE_PRICE;
        $this->ticketServiceMock->expects($this->once())
            ->method('calculatePrice')
            ->willReturn($price);

        $result = $this->controller->calculatePrice($requestMock);

        $this->assertTrue(Session::has('data_success'));
        $this->assertArrayHasKey('price', Session::get('data_success'));
        $this->assertArrayHasKey('name', Session::get('data_success'));
        $this->assertArrayHasKey('gender', Session::get('data_success'));
        $this->assertArrayHasKey('booking_date', Session::get('data_success'));
        $this->assertArrayHasKey('age', Session::get('data_success'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}