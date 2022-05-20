<?php
declare(strict_types=1);

namespace Modules\Exercise02\Tests\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Exercise02\Http\Controllers\Exercise02Controller;
use Modules\Exercise02\Http\Requests\ATMRequest;
use Modules\Exercise02\Models\ATM;
use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Services\ATMService;
use Tests\TestCase;

class Exercise02ControllerTest extends TestCase
{
    protected $atmService;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->atmService = new ATMService(new ATMRepository(new ATM()));
        $this->controller = new Exercise02Controller($this->atmService);
   }

   public function testFunctionIndex()
   {
       $response = $this->controller->index();

       $this->assertInstanceOf(View::class, $response);
       $this->assertEquals('exercise02::index', $response->getName());
       $this->assertEquals([
           'normalFee' => $this->atmService::NORMAL_FEE,
           'noFee' => $this->atmService::NO_FEE,
           'timePeriod1' => $this->atmService::TIME_PERIOD_1,
           'timePeriod2' => $this->atmService::TIME_PERIOD_2,
           'timePeriod3' => $this->atmService::TIME_PERIOD_3,
       ], $response->getData());
   }

    public function testFunctionTakeATMFee()
    {
        $request = \Mockery::mock(ATMRequest::class);
        $cart = ATM::factory()->isVip()->create()->fresh();

        $request->shouldReceive('validated')->andReturn([
            'card_id' => $cart->card_id
        ]);

        $response = $this->controller->takeATMFee($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(['fee' => 0], $response->getSession()->all()['calculate']);
    }
}
