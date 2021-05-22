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

    public function testDefaultRules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0'
        ], $request->rules());
    }

    /**
     * @dataProvider wrongTotalProducts
     * @dataProvider wrongTotalCravat
     * @dataProvider wrongTotalWhiteShirt
     * @dataProvider wrongTotalOther
     */
    public function testValidationInvalid($key, $value)
    {
        $request = new CheckoutRequest();
        $validator = Validator::make(['total_products' => $value], $request->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $key));
    }

    function wrongTotalProducts()
    {
        return [
            ['total_products', null],
            ['total_products', 1]
        ];
    }

    function wrongTotalCravat()
    {
        return [
            ['total_products.1', [1 => 1.1111, 2 => 2, 3 => 3]],
            ['total_products.1', [1 => -1, 2 => 2, 3 => 3]],
            ['total_products.1', [1 => 'test Cravat', 2 => 2, 3 => 3]],
        ];
    }

    function wrongTotalWhiteShirt()
    {
        return [
            ['total_products.2', [1 => 1, 2 => 2.22222, 3 => 3]],
            ['total_products.2', [1 => 1, 2 => -1, 3 => 3]],
            ['total_products.2', [1 => 1, 2 => 'test WhiteShirt', 3 => 3]],
        ];
    }

    function wrongTotalOther()
    {
        return [
            ['total_products.3', [1 => 1, 2 => 2, 3 => 3.33333]],
            ['total_products.3', [1 => 1, 2 => 2, 3 => -1]],
            ['total_products.3', [1 => 1, 2 => 2, 3 => 'test Other']],
        ];
    }

    public function testValidationSuccess()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'total_products' => [1 => 1, 2 => 2, 3 => 3],
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
