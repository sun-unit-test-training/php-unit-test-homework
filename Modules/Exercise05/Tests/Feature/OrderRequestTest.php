<?php

namespace Modules\Exercise05\Tests\Feature;

use Tests\TestCase;
use Illuminate\Validation\Rule;
use Modules\Exercise05\Http\Requests\OrderRequest;

class OrderRequestTest extends TestCase
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
}
