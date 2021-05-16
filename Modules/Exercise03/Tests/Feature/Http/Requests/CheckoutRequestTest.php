<?php

namespace Modules\Exercise03\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Illuminate\Support\Arr;

class ProductRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_it_contain_default_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0'
        ], $request->rules());
    }

    /**
     * @dataProvider provideWrongTotalProducts
     * @dataProvider provideWrongTotalCravat
     * @dataProvider provideWrongTotalWhiteShirt
     * @dataProvider provideWrongTotalOther
     */
    public function test_validation_fails_when_input_invalid($key, $value)
    {
        $request = new CheckoutRequest();
        $validator = Validator::make(['total_products' => $value], $request->rules());

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
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'total_products' => [1 => 1, 2 => 2, 3 => 3],
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
