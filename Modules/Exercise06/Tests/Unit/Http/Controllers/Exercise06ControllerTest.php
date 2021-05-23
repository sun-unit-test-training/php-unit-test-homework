<?php

namespace Modules\Exercise06\Tests\Unit\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Exercise06ControllerTest extends TestCase
{
    protected $controller;
    protected $serviceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = $this->mock(CalculateService::class);
        $this->controller = new Exercise06Controller($this->serviceMock);
    }

    public function test_index_success()
    {
        $response = $this->controller->index();

        $this->assertEquals('exercise06::index', $response->getName());
        $this->assertArrayHasKey('case1', $response->getData());
        $this->assertArrayHasKey('case2', $response->getData());
        $this->assertArrayHasKey('freeTimeForMovie', $response->getData());
    }

    public function test_calculate_success()
    {
        $inputs = [
            'bill' => 1000,
            'has_watch' => true
        ];
        $request = $this->mock(Exercise06Request::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($inputs);

        $this->serviceMock->shouldReceive('calculate')
            ->with($inputs['bill'], isset($inputs['has_watch']))
            ->andReturn(1);

        $response = $this->controller->calculate($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertArrayHasKey('time', $response->getSession()->get('result'));
    }
}
