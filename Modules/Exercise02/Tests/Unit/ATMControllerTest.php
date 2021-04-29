<?php

namespace Modules\Exercise02\Tests\Unit;

use Tests\TestCase;
use Modules\Exercise02\Http\Controllers\Exercise02Controller;
use Modules\Exercise02\Services\ATMService;
use Illuminate\View\View;
use Modules\Exercise02\Http\Requests\ATMRequest;
use Illuminate\Http\RedirectResponse;

class ATMControllerTest extends TestCase
{
    protected $controller;
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->mock(ATMService::class)->makePartial();
        $this->controller = new Exercise02Controller($this->service);
    }

    public function test_index()
    {
        $result = $this->controller->index();
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('exercise02::index', $result->getName());
    }

    public function test_take_atm_fee()
    {
        $request = $this->mock(ATMRequest::class)->makePartial();
        $request->shouldReceive('validated')->andReturn([
            'card_id' => 1,
        ]);
        $this->service->shouldReceive('calculate')->andReturn(0);
        $result = $this->controller->takeATMFee($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
