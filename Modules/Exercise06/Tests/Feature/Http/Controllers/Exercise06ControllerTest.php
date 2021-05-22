<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class Exercise06ControllerTest extends TestCase
{
    protected $controller;
    protected $calculateService;

    protected function setUp(): void
    {
        parent::setup();

        $this->calculateService = $this->mock(CalculateService::class);
        $this->controller = new Exercise06Controller($this->calculateService);
    }

    public function test_index_return_view_success()
    {
        $expected = [
            'case1' => CalculateService::CASE_1,
            'case2' => CalculateService::CASE_2,
            'freeTimeForMovie' => CalculateService::FREE_TIME_FOR_MOVIE,
        ];
        $response = $this->controller->index();

        $this->assertEquals('exercise06::index', $response->getName());
        $this->assertEquals($expected, $response->getData());
    }

    public function test_calculate_return_success()
    {
        $inputs = [
            'bill' => 1,
            'has_watch' => 1
        ];
        $request = $this->mock(Exercise06Request::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($inputs);

        $this->calculateService->shouldReceive('calculate')
            ->with($inputs['bill'], isset($inputs['has_watch']))
            ->andReturn(1);

        $response = $this->controller->calculate($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(['time' => 1], $response->getSession()->get('result'));
    }
}
