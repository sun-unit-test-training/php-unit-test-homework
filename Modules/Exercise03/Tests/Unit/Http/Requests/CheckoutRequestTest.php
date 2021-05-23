<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ], $request->rules());
    }

    /**
     * @dataProvider input_wrong
     */
    public function test_validation_fails_when_input_wrong($input)
    {
        $request = new CheckoutRequest();

        $validator = Validator::make([
            'total_products' => $input['total_products'],
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }

    function input_wrong()
    {
        return [
            [
                [
                    'total_products' => '',
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
                    'total_products' => [2 => 5.5],
                ]
            ],
            [
                [
                    'total_products' => [3 => 'mk'],
                ]
            ],
        ];
    }

    public function test_validation_pass()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'total_products' => [
                1 => 1,
                2 => 2,
            ],
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
