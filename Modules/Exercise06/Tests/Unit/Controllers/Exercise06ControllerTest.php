<?php

namespace Modules\Exercise06\Tests\Unit\Controllers;

use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class Exercise06ControllerTest extends TestCase
{
    public function test_index()
    {
        $calculateService = $this->mock(CalculateService::class);
        $controller = new Exercise06Controller($calculateService);

        $result = $controller->index();

        $this->assertEquals('exercise06::index', $result->name());
        $this->assertEquals([
            'case1' => CalculateService::CASE_1,
            'case2' => CalculateService::CASE_2,
            'freeTimeForMovie' => CalculateService::FREE_TIME_FOR_MOVIE,
        ], $result->getData());
    }

    public function test_calculate_success()
    {
        $response = $this->post(action([Exercise06Controller::class, 'calculate']), [
            'bill' => 100,
            'has_watch' => true,
        ]);

        $response->assertStatus(302);
        $this->assertTrue($response->isRedirection());
        $response->assertSessionHas('result');
        $response->assertSessionHas('_old_input');
    }

    /**
     * @param $input
     * @dataProvider invalid_input_data
     */
    public function test_calculate_with_invalid_input($input)
    {
        $response = $this->post(action([Exercise06Controller::class, 'calculate']), $input);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('bill');
        $this->assertTrue($response->isRedirection());
    }

    public function invalid_input_data()
    {
        return [
            [
                []
            ],
            [
                [
                    'bill' => 'a',
                    'has_watch' => true,
                ]
            ],
            [
                [
                    'bill' => '-1',
                    'has_watch' => true,
                ]
            ],
        ];
    }
}
