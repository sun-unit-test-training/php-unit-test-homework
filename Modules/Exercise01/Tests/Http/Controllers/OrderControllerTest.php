<?php
declare(strict_types=1);

namespace Modules\Unit\Exercise01\Tests\Http\Controllers;

use Illuminate\View\View;
use Modules\Exercise01\Http\Controllers\OrderController;
use Modules\Exercise01\Http\Requests\OrderRequest;
use Modules\Exercise01\Models\Voucher;
use Modules\Exercise01\Services\DTO\Price;
use Modules\Exercise01\Services\PriceService;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    protected $priceService;
    protected $orderController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->priceService = new PriceService();
        $this->orderController = new OrderController($this->priceService);
    }

    public function testFunctionShowForm()
    {
        $response = $this->orderController->showForm();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise01::order', $response->getName());
        $this->assertEquals([
            'unitPrice' => $this->priceService::UNIT_PRICE,
            'voucherUnitPrice' => $this->priceService::VOUCHER_UNIT_PRICE,
            'specialTimeUnitPrice' => $this->priceService::SPECIAL_TIME_UNIT_PRICE,
            'specialTimePeriod' => $this->priceService::SPECIAL_TIME_PERIOD,
        ], $response->getData());
    }

    public function testFunctionCreateNoVoucher()
    {
       $request = \Mockery::mock(OrderRequest::class);
       $request->shouldReceive('validated')->andReturn([
           'quantity' => '1',
           'voucher' => ''
       ]);

       $response = $this->priceService->calculate(1, '');
       $this->assertInstanceOf(Price::class, $response);
       $this->assertEquals(PriceService::UNIT_PRICE, $response->getTotal());
       $this->assertEquals(0, $response->getSpecialTimeDiscount());
       $this->assertEquals(0, $response->getVoucherDiscount());
    }

    public function testFunctionCreateWithVoucher()
    {
        $request = \Mockery::mock(OrderRequest::class);
        $voucher = Voucher::factory()->active()->create()->fresh();

        $request->shouldReceive('validated')->andReturn([
            'quantity' => '2',
            'voucher' => $voucher->code
        ]);

        $response = $this->priceService->calculate(2, $voucher->code);
        $this->assertInstanceOf(Price::class, $response);
        $this->assertEquals(590, $response->getTotal());
        $this->assertEquals(0, $response->getSpecialTimeDiscount());
        $this->assertEquals(390, $response->getVoucherDiscount());
    }
}
