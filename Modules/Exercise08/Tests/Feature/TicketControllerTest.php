<?php

namespace Modules\Exercise08\Tests\Feature;

use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    private $ticketService;

    public function setUp(): void
    {
        parent::setUp();
        $this->ticketService = $this->mock(TicketService::class);
    }

    public function test_show_index()
    {
        $url = action([TicketController::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise08::index');
    }


    private function invalidInputs($inputs)
    {
        $validInputs = [
            'name' => 'Tai',
            'age' => 30,
            'gender' => 'male',
            'booking_date' => '26-03-2021',
        ];

        return array_filter(array_merge($validInputs, $inputs), function ($value) {
            return $value !== null;
        });
    }

    public function providerInvalidName()
    {
        return [
            'Name is required' => ['name', null],
        ];
    }

    public function providerInvalidAge()
    {
        return [
            'Age is required' => ['age', null],
            'Age is integer' => ['age', 50.4],
        ];
    }

    public function providerInvalidGender()
    {
        return [
            'Gender is required' => ['gender', null],
        ];
    }

    public function providerInvalidBookingDate()
    {
        return [
            'Booking Date is required' => ['booking_date', null],
            'Booking Date is date' => ['booking_date', 'fasdfsdf'],
        ];
    }

    /**
     * @dataProvider providerInvalidName
     * @dataProvider providerInvalidAge
     * @dataProvider providerInvalidGender
     * @dataProvider providerInvalidBookingDate
     */
    public function test_calculatePrice_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([TicketController::class, 'calculatePrice']);

        $inputs = $this->invalidInputs([
            $inputKey => $inputValue,
        ]);

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    public function test_calculatePrice_when_input_valid()
    {
        $url = action([TicketController::class, 'calculatePrice']);

        $this->ticketService->shouldReceive('calculatePrice')->andReturn(100);

        $inputs = [
            'name' => 'Tai',
            'age' => 30,
            'gender' => 'male',
            'booking_date' => '26-03-2021',
        ];
        $response = $this->post($url, $inputs);

        $response->assertSessionHasInput($inputs);
        $response->assertSessionHas('data_success');
    }
}
