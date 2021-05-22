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

    public function testDefaultRules()
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

    public function testValidationSuccess()
    {
        $request = new OrderRequest();
        $validator = Validator::make([
                'price' => 1000,
                'option_receive' => 1,
                'option_coupon' => 2
            ], $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider dataWrong
     */
    public function testValidationInvalid($key, $value)
    {
        $request = new OrderRequest();
        $validator = Validator::make($value, $request->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $key));
    }

    function dataWrong()
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
            [
                'option_receive', [
                    'price' => 10,
                    'option_receive' => null,
                    'option_coupon' => 1
                ]
            ],
            [
                'option_receive', [
                    'price' => 100,
                    'option_receive' => 0,
                    'option_coupon' => 1
                ]
            ],
            [
                'option_coupon', [
                    'price' => 999,
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
}
