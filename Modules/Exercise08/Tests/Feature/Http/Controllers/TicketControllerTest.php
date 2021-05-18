<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    protected $ticketService;
    protected $ticketController;

    protected function setUp(): void
    {
        parent::setup();

        $this->ticketService = $this->mock(TicketService::class);
        $this->ticketController = new TicketController(
            $this->ticketService
        );
    }

    public function test_index_show_view()
    {
        $response = $this->ticketController->index();
        $this->assertEquals('exercise08::index', $response->getName());
    }

    public function test_calculate_price_return_success()
    {
        $input = [
            'age' => 15,
            'booking_date' => '2020/09/22',
            'gender' => 'female',
            'name' => 'Test'
        ];
        $expected = array_merge(['price' => TicketService::PRICE_IN_TUESDAY], $input);
        $mockRequest = $this->mock(CalculateRequest::class);
        $mockRequest->shouldReceive('only')->andReturn($input);
        $this->ticketService->shouldReceive('calculatePrice')->andReturn(TicketService::PRICE_IN_TUESDAY);
        $response = $this->ticketController->calculatePrice($mockRequest);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals($expected, $response->getSession()->get('data_success'));
    }
}
