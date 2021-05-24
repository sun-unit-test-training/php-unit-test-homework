<?php

namespace Modules\Tests\Exercise06\Tests\Feature\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class Exercise06ControllerTest extends TestCase
{
    private $controller;
    private $mockCalculateService;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockCalculateService = $this->mock(CalculateService::class);
        $this->controller = new Exercise06Controller($this->mockCalculateService);
    }

    public function testIndex()
    {
        $response = $this->controller->index();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise06::index', $response->getName());
    }

    public function testCalculate()
    {
        $input = [
            'bill' => 2021,
            'has_watch' => true,
        ];

        $mockRequest = $this->mock(Exercise06Request::class);
        $mockRequest->shouldReceive('validated')
            ->andReturn($input);

        $this->mockCalculateService->shouldReceive('calculate')
            ->with($input['bill'], $input['has_watch'])
            ->andReturn(60);

        $res = $this->controller->calculate($mockRequest);
        $this->assertInstanceOf(RedirectResponse::class, $res);
    }
}
