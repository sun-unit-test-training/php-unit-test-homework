<?php
declare(strict_types=1);

namespace Modules\Exercise08\Tests\Http\Controllers;

use Modules\Exercise08\Http\Controllers\TicketController;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    protected $ticketService;
    protected $ticketController;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testShowDataFormCheckout()
    {
        $url = action([TicketController::class, 'index']);
        $response = $this->get($url);
        $response->assertViewIs('exercise08::index');
        $response->assertSessionMissing('data_success');
    }

    public function testValidateForm()
    {
        $url = $this->getUrlCalculatePrice();
        $responseNotInput = $this->post($url, [
            'name' => '',
            'booking_date' => '',
            'gender' => '',
            'age' => ''
        ]);

        $responseNotInput->assertSessionHasErrors(['name', 'booking_date', 'gender', 'age']);

        $responseInputWrong = $this->post($url, [
            'name' => 'Abc',
            'booking_date' => '123',
            'gender' => 'male',
            'age' => 'date'
        ]);

        $responseInputWrong->assertSessionDoesntHaveErrors(['name', 'gender']);
        $responseInputWrong->assertSessionHasErrors(['booking_date', 'age']);
    }

    public function testSubmitValidForm()
    {
        $url = $this->getUrlCalculatePrice();
        $request = [
            'age' => '18',
            'booking_date' => '05/06/2022',
            'gender' => 'female',
            'name' => 'Abc',
        ];

        $response = $this->post($url, $request);

        $response->assertSessionDoesntHaveErrors(['name', 'booking_date', 'gender', 'age']);
        $response->assertSessionHas('data_success');
    }

    public function getUrlCalculatePrice()
    {
        return action([TicketController::class, 'calculatePrice']);
    }
}
