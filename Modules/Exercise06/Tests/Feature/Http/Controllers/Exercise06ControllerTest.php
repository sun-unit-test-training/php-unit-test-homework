<?php

namespace Tests\Feature\Http\Controllers;

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

    public function test_index()
    {
        $response = $this->exercise06Controller->index();

        $this->assertEquals('exercise06::index', $response->getName());
        $this->assertEquals([
            'case1' => CalculateService::CASE_1,
            'case2' => CalculateService::CASE_2,
            'freeTimeForMovie' => CalculateService::FREE_TIME_FOR_MOVIE,
        ], $response->getData());
    }

    public function test_calculate()
    {

        $frmInput = [
            'bill' => 100, 
            'has_watch' => 1
        ];
        
        $request = $this->mock(Exercise06Request::class);
        $request->shouldReceive('validated')->andReturn($frmInput);
        $this->calculateService->shouldReceive('calculate')->andReturn(0);

        $response = $this->exercise06Controller->calculate($request);
        $this->assertInstanceOf(RedirectResponse::class, $response);

        $expected = [
            'time' => 0
        ];
        $this->assertEquals($expected, $response->getSession()->get('result'));
    }
}