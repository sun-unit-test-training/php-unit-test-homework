<?php

namespace Modules\Exercise06\Tests\Feature\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\TestCase;

class Exercise06Request extends TestCase
{
    public function test_rules()
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

    public function test_validation_fails_when_data_empty()
    {
        $request = new OrderRequest();
        $validator = Validator::make([
            'price' => null,
            'option_receive' => null,
            'option_coupon' => null,
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }

    public function test_validation_success()
    {
        $request = new OrderRequest();
        $validator = Validator::make([
            'price' => 99,
            'option_receive' => 1,
            'option_coupon' => 1,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
