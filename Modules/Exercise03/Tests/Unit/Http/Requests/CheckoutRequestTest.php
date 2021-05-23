<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    protected $checkoutRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutRequest = new CheckoutRequest();
    }

    public function test_rules()
    {
        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ], $this->checkoutRequest->rules());
    }

    /**
     * @dataProvider provideWrongTotalProducts
     * @dataProvider provideWrongTotalCravat
     * @dataProvider provideWrongTotalWhiteShirt
     * @dataProvider provideWrongTotalOther
     */
    public function test_validation_failure_when_input_invalid($key, $value)
    {
        $validator = Validator::make(['total_products' => $value], $this->checkoutRequest->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $key));
    }

    function provideWrongTotalProducts()
    {
        return [
            ['total_products', null],
            ['total_products', 1]
        ];
    }

    function provideWrongTotalCravat()
    {
        return [
            ['total_products.1', [1 => 1.1, 2 => 2, 3 => 3]],
            ['total_products.1', [1 => -1, 2 => 2, 3 => 3]],
        ];
    }

    function provideWrongTotalWhiteShirt()
    {
        return [
            ['total_products.2', [1 => 1, 2 => 2.2, 3 => 3]],
            ['total_products.2', [1 => 1, 2 => -1, 3 => 3]],
        ];
    }

    function provideWrongTotalOther()
    {
        return [
            ['total_products.3', [1 => 1, 2 => 2, 3 => 3.3]],
            ['total_products.3', [1 => 1, 2 => 2, 3 => -1]],
        ];
    }

    public function test_validation_success()
    {
        $validator = Validator::make([
            'total_products' => [
                1 => 1,
                2 => 2,
                3 => 3
            ],
        ], $this->checkoutRequest->rules());

        $this->assertTrue($validator->passes());
    }
}
