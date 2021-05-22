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

    protected $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serviceMock = $this->mock(CalculateService::class);
    }

    function testIndex()
    {
        $url = action([Exercise06Controller::class, 'index']);
        $response = $this->get($url);

        $response->assertViewIs('exercise06::index');

        $service = new CalculateService();
        $this->assertEquals($response->viewData('case1'), $service::CASE_1);
        $this->assertEquals($response->viewData('case2'), $service::CASE_2);
        $this->assertEquals($response->viewData('freeTimeForMovie'), $service::FREE_TIME_FOR_MOVIE);
    }

    function testCalculate()
    {
        $request = $this->mock(Exercise06Request::class);
        $request->shouldReceive('validated')->andReturn([
            'bill' => 5000,
            'has_watch' => 1
        ]);

        $this->serviceMock->shouldReceive('calculate')
            ->andReturn(12);

        $url = action([Exercise06Controller::class, 'calculate']);
        $response = $this->post($url);

        $response->assertRedirect();
        $this->assertEquals(['time' => 12], $response->getSession()->all()['result']);
    }
}
