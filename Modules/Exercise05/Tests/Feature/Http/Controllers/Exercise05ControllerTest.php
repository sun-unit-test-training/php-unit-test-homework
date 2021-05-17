<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Tests\TestCase;
use Modules\Exercise05\Services\OrderService;
use Tests\SetupDatabaseTrait;

class Exercise05ControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $orderServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->orderServiceMock = $this->mock(OrderService::class);
    }

    function test_it_index()
    {
        $url = action([Exercise05Controller::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise05::index');
        $response->assertViewHasAll([
            'optionReceives',
            'optionCoupons'
        ]);
        $response->assertSessionMissing('order');
    }

    public function test_store()
    {
        $input = [
            'price' => 1000,
            'option_receive' => '1',
            'option_coupon' => '1',
        ];
        $result = [
            'price' => 1000,
            'discount_pizza' => 'Khuyến mại pizza thứ 2',
            'discount_potato' => null,
        ];
    
        $url = action([Exercise05Controller::class, 'store']);

        $this->orderServiceMock
            ->shouldReceive('handleDiscount')
            ->with($input)
            ->andReturn($result);

        $response = $this->post($url, $input);

        $response->assertViewIs('exercise05::detail');
        $response->assertViewHasAll([
            'resultOrder',
            'detailOrder'
        ]);
    }
}