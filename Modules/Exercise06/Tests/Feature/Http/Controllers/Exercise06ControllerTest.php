<?php

namespace Modules\Exercise06\Tests\Feature\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Mockery\MockInterface;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class Exercise06ControllerTest extends TestCase
{
    /**
     * @var MockInterface
     */
    protected $calculateServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calculateServiceMock = $this->mock(CalculateService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test__contruct()
    {
        $controller = new Exercise06Controller($this->calculateServiceMock);

        $this->assertInstanceOf(Exercise06Controller::class, $controller);
    }

    public function test_index()
    {
        $url = action([Exercise06Controller::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise06::index');
        $response->assertViewHasAll([
            'case1',
            'case2',
            'freeTimeForMovie',
        ]);
    }

    public function test_calculate()
    {
        $input = [
            'bill' => 99,
            'has_watch' => true,
        ];

        $request = $this->mock(Exercise06Request::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($input);

        $this->calculateServiceMock->shouldReceive('calculate')
            ->with($input['bill'], $input['has_watch'])
            ->once()
            ->andReturn(180);

        $controller = new Exercise06Controller($this->calculateServiceMock);

        $this->assertInstanceOf(RedirectResponse::class, $controller->calculate($request));
    }
}
