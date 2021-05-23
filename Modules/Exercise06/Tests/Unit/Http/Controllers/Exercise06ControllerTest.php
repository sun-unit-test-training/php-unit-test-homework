<?php

namespace Modules\Exercise06\Tests\Unit\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class Exercise06ControllerTest extends TestCase
{
    protected $calculateService;
    protected $exercise06Controller;

    protected function setUp(): void
    {
        parent::setup();

        $this->calculateService = $this->mock(CalculateService::class);
        $this->exercise06Controller = new Exercise06Controller($this->calculateService);
    }

    public function test__construct()
    {
        $controller = new Exercise06Controller($this->calculateService);

        $this->assertInstanceOf(Exercise06Controller::class, $controller);

    }

    public function test_index_return_view()
    {
        $view = $this->exercise06Controller->index();

        $this->assertEquals('exercise06::index', $view->name());
        $this->assertEquals([
            'case1' => CalculateService::CASE_1,
            'case2' => CalculateService::CASE_2,
            'freeTimeForMovie' => CalculateService::FREE_TIME_FOR_MOVIE,
        ], $view->getData());
    }

    public function test_calculate()
    {

        $input = [
            'bill' => 100, 
            'has_watch' => 1
        ];

        $request = $this->mock(Exercise06Request::class);
        $request->shouldReceive('validated')->andReturn($input);
        $this->calculateService->shouldReceive('calculate')->andReturn(0);
        $response = $this->exercise06Controller->calculate($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals([
            'time' => 0
        ], $response->getSession()->get('result'));
    }
}
