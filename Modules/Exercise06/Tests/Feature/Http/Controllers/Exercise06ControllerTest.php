<?php

namespace Modules\Exercise06\Tests\Feature\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class Exercise06ControllerTest extends TestCase
{
    protected $calculateService;
    protected $exerciseController;

    protected function setUp(): void
    {
        parent::setup();

        $this->calculateService = $this->mock(CalculateService::class);
        $this->exerciseController = new Exercise06Controller($this->calculateService);
    }

    public function test_index_return_view()
    {
        $expectedResponse = [
            'case1' => CalculateService::CASE_1,
            'case2' => CalculateService::CASE_2,
            'freeTimeForMovie' => CalculateService::FREE_TIME_FOR_MOVIE,
        ];
        $response = $this->exerciseController->index();

        $this->assertEquals('exercise06::index', $response->getName());
        $this->assertEquals($expectedResponse, $response->getData());
    }

    public function test_calculate()
    {
        $expectedTime = 1;
        $formRequest = ['bill' => 1, 'has_watch' => true];
        $mockRequest = $this->mock(Exercise06Request::class);
        $mockRequest->shouldReceive('validated')->andReturn($formRequest);
        $this->calculateService
            ->shouldReceive('calculate')
            ->with($formRequest['bill'], $formRequest['has_watch'])
            ->andReturn($expectedTime);
        $response = $this->exerciseController->calculate($mockRequest);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(['time' => $expectedTime], $response->getSession()->get('result'));
    }
}
