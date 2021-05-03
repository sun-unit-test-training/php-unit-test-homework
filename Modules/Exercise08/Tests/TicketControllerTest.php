<?php

namespace Modules\Exercise08\Tests;

use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use Mockery;

class TicketControllerTest extends TestCase
{
    public function test__construct()
    {
        $service = Mockery::mock(TicketService::class);
        $controller = new TicketController($service);
        $serviceRef = $this->getHiddenProperty($controller, 'ticketService');
        $this->assertSame($service, $serviceRef->getValue($controller));
    }

    public function test_index()
    {
        $response = $this->get(action([TicketController::class, 'index']));
        $response->assertStatus(200);
        $response->assertViewIs('exercise08::index');
    }

    public function test_calculate_price_success()
    {
        $response = $this->post(action([TicketController::class, 'calculatePrice']), [
            'age' => 31,
            'booking_date' => '2021-01-27',
            'gender' => 'super human',
            'name' => 'The Thao',
        ]);

        $response->assertStatus(302);
        $this->assertTrue($response->isRedirection());
        $response->assertSessionHas('data_success');
        $response->assertSessionHas('_old_input');
    }

    public function test_calculate_price_return_exception()
    {
        $response = $this->post(action([TicketController::class, 'calculatePrice']), [
            'name' => 'The Thao',
            'age' => -10,
            'booking_date' => '2021-01-27',
            'gender' => 'super human',
        ]);

        $response->assertStatus(500);
        $this->assertSame(0, $response->exception->getCode());
        $this->assertSame('The age must be from 0 to 120', $response->exception->getMessage());
    }

    /**
     * @dataProvider input_calculate_price_error
     * @param $input
     * @param $errorRes
     */
    public function test_calculate_price_error($input, $errorRes)
    {
        $response = $this->post(action([TicketController::class, 'calculatePrice']), $input);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($errorRes);
        $this->assertTrue($response->isRedirection());
    }

    public function input_calculate_price_error()
    {
        return [
            [
                [
                    'age' => 31,
                    'booking_date' => '2021-01-27',
                    'gender' => 'super human',
                ], 'name',
            ],
            [
                [
                    'name' => 'The Thao',
                    'booking_date' => '2021-01-27',
                    'gender' => 'super human',
                ], 'age',
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 31,
                    'booking_date' => '2021-01-27',
                ], 'gender',
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 31,
                    'gender' => 'super human',
                ], 'booking_date',
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 31,
                    'booking_date' => 'is not date',
                    'gender' => 'super human',
                ], 'booking_date',
            ],
        ];
    }
}
