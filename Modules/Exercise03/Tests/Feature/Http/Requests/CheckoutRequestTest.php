<?php

namespace Modules\Exercise03\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;

class CheckoutRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_it_contain_default_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ], $request->rules());
    }

    /**
     * @dataProvider provider_test_validation_wrong
     */
    public function test_validation_fails_when_data_wrong($input)
    {
        $request = new CheckoutRequest();

        $validator = Validator::make([
            'total_products' => $input['total_products'],
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }

    function provider_test_validation_wrong()
    {
        return [
            [
                [
                    'total_products' => null,
                ]
            ],
            [
                [
                    'total_products' => [],
                ]
            ],
            [
                [
                    'total_products' => [1 => -1],
                ]
            ],
            [
                [
                    'total_products' => [1 => 5.5],
                ]
            ],
            [
                [
                    'total_products' => [1 => 'aespa'],
                ]
            ],
        ];
    }

    public function test_validation_success()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'total_products' => [1 => 10],
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
