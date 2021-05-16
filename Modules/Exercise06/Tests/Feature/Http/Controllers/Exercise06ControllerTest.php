<?php

namespace Modules\Exercise06\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise06\Http\Controllers\Exercise06Controller as Exercise;
use Modules\Exercise06\Services\CalculateService;
use Tests\SetupDatabaseTrait;

class Exercise06ControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $serviceMock;
    protected $controllerMethod;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->serviceMock = $this->mock(CalculateService::class);
        $this->controllerMethod = 'calculate';
    }

    function test_index()
    {
        $expectedCase1 = CalculateService::CASE_1;
        $expectedCase2 = CalculateService::CASE_2;
        $expectedFreeTimeForMovie = CalculateService::FREE_TIME_FOR_MOVIE;

        $url = action([Exercise::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise06::index');
        $response->assertViewHasAll([
            'case1',
            'case2',
            'freeTimeForMovie',
        ]);
        $this->assertEquals($response->viewData('case1'), $expectedCase1);
        $this->assertEquals($response->viewData('case2'), $expectedCase2);
        $this->assertEquals($response->viewData('freeTimeForMovie'), $expectedFreeTimeForMovie);
    }

    /**
     * @dataProvider provideWrongBill
     */
    function test_it_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([Exercise::class, $this->controllerMethod]);
        $inputs = [$inputKey => $inputValue];

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    function provideWrongBill()
    {
        return [
            'Bill is missing' => [null, null],
            'Bill is null' => ['bill', null],
            'Bill is not integer' => ['bill', 'not_integer'],
            'Bill minimum is less than zero' => ['bill', -1],
        ];
    }

    function test_it_show_error_when_has_watch_invalid()
    {
        $url = action([Exercise::class, $this->controllerMethod]);
        $inputs = [
            'bill' => 1,
            'has_watch' => 'not_boolean',
        ];

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors(['has_watch']);
    }

    function test_calculate_success()
    {
        $dummyInput = [
            'bill' => 1,
            'has_watch' => true,
        ];
        $expectedTime = CalculateService::FREE_TIME_FOR_MOVIE;

        $this->serviceMock
            ->shouldReceive('calculate')
            ->andReturn($expectedTime);

        $url = action([Exercise::class, $this->controllerMethod]);

        $response = $this->post($url, $dummyInput);

        $response->assertSessionDoesntHaveErrors(['bill']);
        $response->assertSessionHasInput(['bill']);
        $response->assertSessionHas('result', function ($result) use ($expectedTime) {
            return $result['time'] == $expectedTime;
        });
    }
}
