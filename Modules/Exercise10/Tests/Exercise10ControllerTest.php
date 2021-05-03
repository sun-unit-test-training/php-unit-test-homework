<?php

namespace Modules\Exercise10\Tests;

use Illuminate\Support\Facades\Artisan;
use Modules\Exercise10\Contracts\Services\PrepaidInterface;
use Modules\Exercise10\Http\Controllers\Exercise10Controller;
use Tests\TestCase;
use Mockery;

class Exercise10ControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('module:seed Exercise10');
    }

    public function test__construct()
    {
        $service = Mockery::mock(PrepaidInterface::class);
        $controller = new Exercise10Controller($service);
        $this->assertInstanceOf(Exercise10Controller::class, $controller);
    }

    public function test_index()
    {
        $response = $this->get(action([Exercise10Controller::class, 'index']));
        $response->assertStatus(200);
        $response->assertViewIs('exercise10::index');
    }

    /**
     * @dataProvider input_for_prepaid_error
     * @param $input
     * @param $responseErr
     */
    public function test_prepaid_error($input, $responseErr)
    {
        $response = $this->post(action([Exercise10Controller::class, 'prepaid']), $input);

        $response->assertStatus(302);
        $this->assertTrue($response->isRedirection());
        $response->assertSessionHasErrors($responseErr);
    }

    public function input_for_prepaid_error()
    {
        return [
            [
                [
                    'type' => 11,
                    'price' => 22,
                    'ballot' => false,
                ],
                [
                    'type'
                ]
            ],
            [
                [
                    'type' => 11,
                    'ballot' => false,
                ],
                [
                    'type', 'price'
                ]
            ],
            [
                [
                    'ballot' => false,
                ],
                [
                    'type', 'price'
                ]
            ],
        ];
    }

    /**
     * @dataProvider input_for_prepaid_success
     * @param $input
     * @param $expected
     */
    public function test_prepaid_success($input, $expected)
    {
        $response = $this->post(action([Exercise10Controller::class, 'prepaid']), $input);

        $response->assertStatus(200);
        $response->assertViewIs('exercise10::index');
        $resultsResponse = $response->viewData('results');
        $this->assertSame($expected, $resultsResponse);
    }

    public function input_for_prepaid_success()
    {
        return [
            [
                [
                    'type' => 1,
                    'price' => 3000,
                    'ballot' => true,
                ],
                [
                    'type' => 1,
                    'price' => 3000,
                    'ballot' => true,
                    'bonus' => 30,
                    'amount' => 2970,
                ]
            ],
            [
                [
                    'type' => 1,
                    'price' => 10000,
                    'ballot' => true,
                ],
                [
                    'type' => 1,
                    'price' => 10000,
                    'ballot' => true,
                    'bonus' => 400,
                    'amount' => 9600,
                ]
            ],
            [
                [
                    'type' => 2,
                    'price' => 22,
                    'ballot' => true,
                ],
                [
                    'type' => 2,
                    'price' => 22,
                    'ballot' => true,
                    'bonus' => 0,
                    'amount' => 22,
                ]
            ],
            [
                [
                    'type' => 1,
                    'price' => 22,
                    'ballot' => false,
                ],
                [
                    'type' => 1,
                    'price' => 22,
                    'ballot' => false,
                    'bonus' => 0,
                    'amount' => 22,
                ]
            ],
            [
                [
                    'type' => 2,
                    'price' => 22,
                    'ballot' => false,
                ],
                [
                    'type' => 2,
                    'price' => 22,
                    'ballot' => false,
                    'bonus' => 0,
                    'amount' => 22,
                ]
            ],
            [
                [
                    'type' => 3,
                    'price' => 22,
                    'ballot' => false,
                ],
                [
                    'type' => 3,
                    'price' => 22,
                    'ballot' => false,
                    'bonus' => 0,
                    'amount' => 22,
                ]
            ],
        ];
    }
}
