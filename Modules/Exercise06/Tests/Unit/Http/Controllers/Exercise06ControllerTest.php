<?php

namespace Modules\Exercise06\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Modules\Exercise06\Services\CalculateService;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;

class Exercise06ControllerTest extends TestCase
{
    protected $calculateServiceMock;
    protected $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateServiceMock = $this->createMock(CalculateService::class);
        $this->controller = new Exercise06Controller($this->calculateServiceMock);
    }

    public function test_view_index()
    {
        $view = $this->controller->index();

        $this->assertInstanceOf(View::class, $view);
        $this->assertArrayHasKey('case1', $view->getData());
        $this->assertArrayHasKey('case2', $view->getData());
        $this->assertEquals('exercise06::index', $view->name());
        $this->assertArrayHasKey('freeTimeForMovie', $view->getData());
    }

    public function test_calculate()
    {
        $requestMock = $this->getMockBuilder(Exercise06Request::class)
                            ->onlyMethods(['validated'])
                            ->getMock();

        $requestMock->expects($this->once())
                    ->method('validated')
                    ->willReturn([
                        'bill' => 3000,
                        'hasWatch' => true
                    ]);

        $result = $this->controller->calculate($requestMock);

        $this->assertTrue(Session::has('result'));
        $this->assertArrayHasKey('time', Session::get('result'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
