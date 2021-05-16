<?php

namespace Modules\Exercise05\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Services\OrderService;
use Tests\SetupDatabaseTrait;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Illuminate\View\View;

class Exercise05ControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $orderServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderServiceMock = $this->mock(OrderService::class);
    }

    function test_it_index_return_view()
    {
        $url = action([Exercise05Controller::class, 'index']);
        $response = $this->get($url);

        $response->assertViewIs('exercise05::index');

        $this->assertEquals($response->viewData('optionReceives'), config('exercise05.option_receive'));
        $this->assertEquals($response->viewData('optionCoupons'), config('exercise05.option_coupon'));
    }

    function test_it_store_return_view()
    {
        $request = $this->mock(OrderRequest::class);
        $request->shouldReceive('only')->andReturn([
            'price' => 1,
            'option_receive' => 2,
            'option_coupon' => 3
        ]);

        $this->orderServiceMock
            ->shouldReceive('handleDiscount')
            ->andReturn([
                'price' => 123,
                'discount_pizza' => 'discount pizza mock',
                'discount_potato' => 'discount potato mock'
            ]);

        $url = action([Exercise05Controller::class, 'store']);
        $response = $this->post($url);
        $viewResponse = $response->getOriginalContent();
        $viewDataResponse = $viewResponse->getData();

        $this->assertInstanceOf(View::class, $response->getOriginalContent());
        $this->assertEquals($viewResponse->name(), 'exercise05::detail');
        $this->assertEquals($viewDataResponse['resultOrder'], [
            'price' => 123,
            'discount_pizza' => 'discount pizza mock',
            'discount_potato' => 'discount potato mock'
        ]);
        $this->assertEquals($viewDataResponse['detailOrder'], [
            'price' => 1,
            'option_receive' => 2,
            'option_coupon' => 3
        ]);
    }
}
