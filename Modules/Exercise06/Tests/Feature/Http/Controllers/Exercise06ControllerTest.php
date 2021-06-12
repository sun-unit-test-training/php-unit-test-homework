<?php

namespace Modules\Exercise06\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Modules\Exercise06\Services\CalculateService;
use Tests\SetupDatabaseTrait;
use Modules\Exercise06\Http\Requests\Exercise06Request;

class ProductControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->mock(CalculateService::class);;
    }

    function test_it_index_return_view()
    {
        $url = action([Exercise06Controller::class, 'index']);
        $response = $this->get($url);

        $response->assertViewIs('exercise06::index');
        $this->assertEquals($response->viewData('case1'), $this->service::CASE_1);
        $this->assertEquals($response->viewData('case2'), $this->service::CASE_2);
        $this->assertEquals($response->viewData('freeTimeForMovie'), $this->service::FREE_TIME_FOR_MOVIE);
    }

    function test_it_calculate()
    {
        $request = $this->mock(Exercise06Request::class);
        $request->shouldReceive('validated')->andReturn([
            'bill' => 2000,
            'has_watch' => 1
        ]);

        $this->service->shouldReceive('calculate')
            ->andReturn(12);

        $url = action([Exercise06Controller::class, 'calculate']);
        $response = $this->post($url);

        $response->assertRedirect();
        $this->assertEquals(['time' => 12], $response->getSession()->all()['result']);
    }
}
