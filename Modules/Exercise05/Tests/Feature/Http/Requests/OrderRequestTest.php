<?php

namespace Modules\Exercise05\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\SetupDatabaseTrait;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ProductRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_it_contain_default_rules()
    {
        $request = new OrderRequest();

        $this->assertEquals([
            'price' => [
                'required',
                'numeric'
            ],
            'option_receive' => [
                'required',
                Rule::in([
                    config('exercise05.receive_at_store'),
                    config('exercise05.receive_at_home'),
                ])
            ],
            'option_coupon' => [
                'required',
                Rule::in([
                    config('exercise05.no_coupon'),
                    config('exercise05.has_coupon'),
                ])
            ],
        ], $request->rules());
    }

    /**
     * @dataProvider provideWrongPrice
     * @dataProvider provideWrongOptionReceive
     * @dataProvider provideWrongOptionCoupon
     */
    public function test_validation_fails_when_input_invalid($fieldError, $input)
    {
        $request = new OrderRequest();
        $validator = Validator::make($input, $request->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $fieldError));
    }

    function provideWrongPrice()
    {
        return [
            [
                'price', [
                    'price' => null,
                    'option_receive' => 1,
                    'option_coupon' => 1
                ]
            ],
            [
                'price', [
                    'price' => 'price',
                    'option_receive' => 1,
                    'option_coupon' => 1
                ]
            ],
        ];
    }

    function provideWrongOptionReceive()
    {
        return [
            [
                'option_receive', [
                    'price' => 1,
                    'option_receive' => null,
                    'option_coupon' => 1
                ]
            ],
            [
                'option_receive', [
                    'price' => 1,
                    'option_receive' => 0,
                    'option_coupon' => 1
                ]
            ]
        ];
    }

    function provideWrongOptionCoupon()
    {
        return [
            [
                'option_coupon', [
                    'price' => 1,
                    'option_receive' => 1,
                    'option_coupon' => null
                ]
            ],
            [
                'option_coupon', [
                    'price' => 1,
                    'option_receive' => 1,
                    'option_coupon' => 0
                ]
            ]
        ];
    }

    public function test_validation_success()
    {
        $request = new OrderRequest();
        $validator = Validator::make([
                'price' => 1,
                'option_receive' => 1,
                'option_coupon' => 2
            ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
