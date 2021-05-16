<?php

namespace Modules\Exercise08\Tests\Unit\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use Mockery\MockInterface;

class TicketControllerTest extends TestCase
{
    public function test_index()
    {
        $ticketService = $this->mock(TicketService::class);
        $controller = new TicketController($ticketService);

        $result = $controller->index();

        $this->assertEquals('exercise08::index', $result->name());
    }

    public function test_calculate_price_success_with_price()
    {
        $ticketService = $this->mock(TicketService::class, function (MockInterface $mock) {
            $mock->shouldReceive('calculatePrice')
                ->once()
                ->andReturn(100);
        });

        $controller = new TicketController($ticketService);
        $request = new CalculateRequest([
            'age' => 10,
        ]);

        $result = $controller->calculatePrice($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertArrayHasKey('data_success', session()->all());
    }

    public function test_calculate_price_success_without_price()
    {
        $ticketService = $this->mock(TicketService::class, function (MockInterface $mock) {
            $mock->shouldReceive('calculatePrice')
                ->once()
                ->andReturn(false);
        });

        $controller = new TicketController($ticketService);
        $request = new CalculateRequest([
            'age' => 10,
        ]);

        $result = $controller->calculatePrice($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertArrayNotHasKey('data_success', session()->all());
    }
}
