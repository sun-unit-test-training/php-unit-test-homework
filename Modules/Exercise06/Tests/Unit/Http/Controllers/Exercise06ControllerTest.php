<?php

namespace Modules\Exercise06\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Modules\Exercise06\Services\CalculateService;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;

class Exercise06ControllerTest extends TestCase
{
    protected $calculateService;
    protected $exercise06Controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateService = $this->mock(CalculateService::class);
        $this->exercise06Controller = new Exercise06Controller($this->calculateService);
    }

    /**
     * Test index function.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->exercise06Controller->index();
        $this->assertEquals('exercise06::index', $response->getName());
        $this->assertArrayHasKey('case1', $response->getData());
        $this->assertArrayHasKey('case2', $response->getData());
        $this->assertArrayHasKey('freeTimeForMovie', $response->getData());
    }

    /**
     * Test calculate function.
     *
     * @return void
     */
    public function test_calculate()
    {
        $requestMock = $this->getMockBuilder(Exercise06Request::class)
            ->onlyMethods(['validated'])
            ->getMock();
        $requestMock->expects($this->once())
            ->method('validated')
            ->willReturn([
                'bill' => 10,
                'has_watch' => true,
            ]);

        $this->calculateService->shouldReceive('calculate')->once()->andReturn(3600);

        $response = $this->exercise06Controller->calculate($requestMock);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue(Session::has('result'));
        $this->assertArrayHasKey('time', Session::get('result'));
    }
}
