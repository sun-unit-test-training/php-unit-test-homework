<?php

namespace Modules\Exercise07\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Illuminate\Support\Arr;

class CheckoutRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function testRules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'amount' => ['required', 'integer', 'min:1'],
        ], $request->rules());
    }

    public function testValidationSuccess()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'amount' => 1000,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider dataWrongAmount
     */
    public function testValidationInvalid($key, $value)
    {
        $request = new CheckoutRequest();
        $validator = Validator::make($value, $request->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $key));
    }

    function dataWrongAmount()
    {
        return [
            [
                'amount', [
                    'amount' => null,
                    'premium_member' => true,
                    'shipping_express' => true,
                ]
            ],
            [
                'amount', [
                    'amount' => 1.1,
                    'premium_member' => false,
                    'shipping_express' => true,
                ]
            ],
            [
                'amount', [
                    'amount' => 0,
                    'shipping_express' => false,
                    'premium_member' => false
                ]
            ],
            [
                'amount', []
            ],
        ];
    }
}
