<?php

namespace Modules\Exercise01\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise01\Http\Controllers\OrderController;
use Modules\Exercise01\Models\Voucher;
use Modules\Exercise01\Services\DTO\Price;
use Modules\Exercise01\Services\PriceService;
use Tests\SetupDatabaseTrait;

class OrderControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $priceServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->priceServiceMock = $this->mock(PriceService::class);
    }

    function test_it_show_form_order()
    {
        $url = action([OrderController::class, 'showForm']);

        $response = $this->get($url);

        $response->assertViewIs('exercise01::order');
        $response->assertViewHasAll([
            'unitPrice',
            'voucherUnitPrice',
            'specialTimeUnitPrice',
            'specialTimePeriod',
        ]);
        $response->assertSessionMissing('order');
    }

    private function inValidInputs($inputs)
    {
        $validInputs = [
            'quantity' => 1,
            'voucher' => null,
        ];

        return array_filter(array_merge($validInputs, $inputs), function ($value) {
            return $value !== null;
        });
    }

    /**
     * @dataProvider provideWrongQuantity
     * @dataProvider provideWrongVoucher
     */
    function test_it_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([OrderController::class, 'create']);
        $inputs = $this->inValidInputs([
            $inputKey => is_callable($inputValue) ? $inputValue() : $inputValue,
        ]);

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    function provideWrongQuantity()
    {
        return [
            'Quantity is required' => ['quantity', null],
            'Quantity should be integer' => ['quantity', 1.1],
            'Quantity should be greater than 1' => ['quantity', 0],
        ];
    }

    function provideWrongVoucher()
    {
        return [
            'Voucher must exist' => ['voucher', 'this-voucher-not-exist'],
            'Voucher must be active' => [
                'voucher',
                function () {
                    Voucher::factory()->inactive()->create(['code' => 'existed-voucher-but-inactive']);

                    return 'existed-voucher-but-inactive';
                },
            ],
        ];
    }

    /**
     * @dataProvider provideEmptyVoucher
     */
    function test_it_should_not_error_when_input_empty_voucher($voucher)
    {
        $url = action([OrderController::class, 'create']);
        $dummyPrice = new Price(100, 0, 0);
        $this->priceServiceMock
            ->shouldReceive('calculate')
            ->andReturn($dummyPrice);

        $response = $this->post($url, [
            'quantity' => 1,
            'voucher' => $voucher,
        ]);

        $response->assertSessionDoesntHaveErrors(['voucher']);
    }

    function provideEmptyVoucher()
    {
        return [
            'Voucher can be null' => [null],
            'Voucher can be empty string' => [''],
            'Voucher can be string with spaces only' => ['   '],
        ];
    }

    function test_it_create_order_when_input_valid_quantity_and_voucher_code()
    {
        Voucher::factory()->active()->create(['code' => 'existed-voucher']);
        $dummyPrice = new Price(100, 0, 0);
        $this->priceServiceMock
            ->shouldReceive('calculate')
            ->andReturn($dummyPrice);

        $url = action([OrderController::class, 'create']);

        $response = $this->post($url, [
            'quantity' => 1,
            'voucher' => 'existed-voucher',
        ]);

        $response->assertSessionDoesntHaveErrors(['quantity']);
        $response->assertSessionDoesntHaveErrors(['voucher']);
        $response->assertSessionHasInput(['quantity', 'voucher']);
        $response->assertSessionHas('order', function ($order) {
            return $order['quantity'] == 1 && $order['price'] instanceof Price;
        });
    }
}
