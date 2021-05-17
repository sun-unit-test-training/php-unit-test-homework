<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Tests\TestCase;
use Modules\Exercise06\Services\CalculateService;

use Tests\SetupDatabaseTrait;

class Exercise06ControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $calculateMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->calculateMock = $this->mock(CalculateService::class);
    }

    function test_it_index()
    {
        $url = action([Exercise06Controller::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise06::index');
        $response->assertViewHasAll([
            'case1',
            'case2',
            'freeTimeForMovie'
        ]);
        $response->assertSessionMissing('order');
    }

    public function test_calculate_with_has_watch()
    {
        $input = [
            'bill' => 2000,
            'has_watch' => true,
        ];

        $url = action([Exercise06Controller::class, 'calculate']);
        
        $this->calculateMock
                ->shouldReceive('calculate')
                ->with($input['bill'], $input['has_watch'])
                ->andReturn(240);

        $response = $this->post($url, $input);

        $response->assertSessionDoesntHaveErrors(['time']);
        $response->assertSessionHas('result', function ($result) {
            return $result['time'] == 240;
        });
    }
}
