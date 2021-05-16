<?php

namespace Modules\Exercise07\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Illuminate\Support\Arr;

class Exercise06RequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_it_contain_default_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'amount' => ['required', 'integer', 'min:1'],
        ], $request->rules());
    }

    /**
     * @dataProvider provideWrongAmount
     */
    public function test_validation_fails_when_input_invalid($key, $value)
    {
        $request = new CheckoutRequest();
        $validator = Validator::make($value, $request->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $key));
    }

    function provideWrongAmount()
    {
        return [
            [
                'amount', [
                    'amount' => null,
                    'premium_member' => true,
                ]
            ],
            [
                'amount', [
                    'amount' => 1.1,
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
        ];
    }

    public function test_validation_success()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'amount' => 1,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
