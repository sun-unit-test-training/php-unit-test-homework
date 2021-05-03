<?php

namespace Modules\Exercise06\Tests;

use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;
use Mockery;

class Exercise06ControllerTest extends TestCase
{
    public function test__construct()
    {
        $service = Mockery::mock(CalculateService::class);
        $controller = new Exercise06Controller($service);
        $serviceRef = $this->getHiddenProperty($controller, 'service');
        $this->assertSame($service, $serviceRef->getValue($controller));
    }

    public function test_index()
    {
        $response = $this->get(action([Exercise06Controller::class, 'index']));
        $response->assertStatus(200);
        $response->assertViewIs('exercise06::index');

        $case1 = $response->viewData('case1');
        $this->assertEquals([2000, 60], $case1);

        $case2 = $response->viewData('case2');
        $this->assertEquals([5000, 120], $case2);

        $freeTimeForMovie = $response->viewData('freeTimeForMovie');
        $this->assertEquals(180, $freeTimeForMovie);
    }

    public function test_calculate_success()
    {
        $response = $this->post(action([Exercise06Controller::class, 'calculate']), [
            'bill' => 1102,
            'has_watch' => true,
        ]);

        $response->assertStatus(302);
        $this->assertTrue($response->isRedirection());
        $response->assertSessionHas('result');
        $response->assertSessionHas('_old_input');
    }

    /**
     * @dataProvider input_calculate_error
     * @param $input
     */
    public function test_calculate_error($input)
    {
        $response = $this->post(action([Exercise06Controller::class, 'calculate']), $input);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('bill');
        $this->assertTrue($response->isRedirection());
    }

    public function input_calculate_error()
    {
        return [
            [
                [
                    'bill' => 'is not numeric',
                    'has_watch' => true,
                ]
            ],
            [
                [
                    'bill' => -1102,
                    'has_watch' => false,
                ]
            ],
        ];
    }
}
