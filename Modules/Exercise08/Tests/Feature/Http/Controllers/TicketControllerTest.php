<?php

namespace Modules\Exercise08\Tests\Feature\Http\Controllers;

use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    protected $ticketController;
    protected $ticketServiceMock;

    protected function setUp(): void
    {
        parent::setup();

        $this->ticketServiceMock = $this->mock(TicketService::class);
    }

    public function test_it_show_data_form_checkout()
    {
        $url = action([TicketController::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise08::index');
        $response->assertSessionMissing('data_success');
    }


    public function test_calculate_data_when_input_not_age()
    {
        $url = action([TicketController::class, 'calculatePrice']);

        $response = $this->post($url, [
            'booking_date' => '2021/04/22',
            'gender' => 'female',
            'name' => 'Test',
        ]);

        $response->assertSessionHasErrors(['age']);
        $response->assertSessionDoesntHaveErrors(['booking_date']);
        $response->assertSessionDoesntHaveErrors(['gender']);
        $response->assertSessionDoesntHaveErrors(['name']);
    }

    public function test_calculate_data_when_invalid_booking_date()
    {
        $url = action([TicketController::class, 'calculatePrice']);

        $response = $this->post($url, [
            'age' => 15,
            'booking_date' => '2021',
            'gender' => 'female',
        ]);

        $response->assertSessionHasErrors(['booking_date']);
        $response->assertSessionHasErrors(['name']);
        $response->assertSessionDoesntHaveErrors(['age']);
        $response->assertSessionDoesntHaveErrors(['gender']);
    }

    public function test_calculate_data_when_input_valid_return_empty()
    {
        $url = action([TicketController::class, 'calculatePrice']);

        $response = $this->post($url, [
            'age' => 122,
            'booking_date' => '2021/04/22',
            'gender' => 'female',
            'name' => 'Test'
        ]);

        $response->assertSessionDoesntHaveErrors(['booking_date']);
        $response->assertSessionDoesntHaveErrors(['name']);
        $response->assertSessionDoesntHaveErrors(['age']);
        $response->assertSessionDoesntHaveErrors(['gender']);
        $response->assertSessionMissing('data_success');
    }

    public function test_calculate_data_when_input_valid_return_data_booking()
    {
        $this->ticketServiceMock
            ->shouldReceive('calculatePrice')
            ->andReturn(TicketService::PRICE_IN_TUESDAY);

        $url = action([TicketController::class, 'calculatePrice']);

        $response = $this->post($url, [
            'age' => 15,
            'booking_date' => '2021/04/22',
            'gender' => 'female',
            'name' => 'Test'
        ]);

        $response->assertSessionDoesntHaveErrors(['booking_date']);
        $response->assertSessionDoesntHaveErrors(['name']);
        $response->assertSessionDoesntHaveErrors(['age']);
        $response->assertSessionDoesntHaveErrors(['gender']);
        $response->assertSessionHas('data_success');
    }
}
