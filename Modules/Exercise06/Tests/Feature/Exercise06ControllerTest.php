<?php

namespace Modules\Exercise06\Tests\Feature;

use Illuminate\Http\RedirectResponse;
use Mockery;
use Tests\TestCase;
use Tests\SetupDatabaseTrait;
use Modules\Exercise06\Services\CalculateService;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;

class Exercise06ControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->mock(CalculateService::class);
    }

    function testIndexReturnView()
    {
        $controller = new Exercise06Controller($this->service);

        $view = $controller->index();

        $this->assertEquals('exercise06::index', $view->name());
        $this->assertArrayHasKey('case1', $view->getData());
        $this->assertArrayHasKey('case2', $view->getData());
        $this->assertArrayHasKey('freeTimeForMovie', $view->getData());
        $this->assertEquals($view->getData()['case1'], $this->service::CASE_1);
        $this->assertEquals($view->getData()['case2'], $this->service::CASE_2);
        $this->assertEquals($view->getData()['freeTimeForMovie'], $this->service::FREE_TIME_FOR_MOVIE);
    }

    function testFunctionCalculate()
    {
        $data = [
            'bill' => 6000,
            'has_watch' => true,
        ];
        $request = Mockery::mock(Exercise06Request::class);
        $request->shouldReceive('validated')->andReturn($data);
        $this->service->shouldReceive('calculate')->andReturn($data);
        $controller = new Exercise06Controller($this->service);

        $response = $controller->calculate($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals($data , $response->getSession()->all()['result']['time']);
    }
}