<?php

namespace Modules\Exercise07\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\SetupDatabaseTrait;
use Illuminate\Validation\Rule;

class OrderRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_it_contain_default_rules()
    {
        $request = new OrderRequest();

        $this->assertEquals([
            'price' => ['required', 'numeric'],
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
     * @dataProvider provider_test_validation_wrong
     */
    public function test_validation_fails_when_data_wrong($input)
    {
        $request = new OrderRequest();

        $validator = Validator::make([
            'price' => $input['price'],
            'option_receive' => $input['option_receive'],
            'option_coupon' => $input['option_coupon'],
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }

    function provider_test_validation_wrong()
    {
        return [
            [
                [
                    'price' => null,
                    'option_receive' => null,
                    'option_coupon' => null,
                ]
            ],
            [
                [
                    'price' => '05request',
                    'option_receive' => 1,
                    'option_coupon' => 1,
                ]
            ],
            [
                [
                    'price' => 10,
                    'option_receive' => 3,
                    'option_coupon' => 1,
                ]
            ],
            [
                [
                    'price' => 10,
                    'option_receive' => 1,
                    'option_coupon' => 3,
                ]
            ],
        ];
    }

    public function test_validation_success()
    {
        $request = new OrderRequest();

        $validator = Validator::make([
            'price' => 10,
            'option_receive' => config('exercise05.receive_at_store'),
            'option_coupon' => config('exercise05.no_coupon'),
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
