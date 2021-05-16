<?php

namespace Modules\Exercise05\Tests\Unit\Requests;

use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\TestCase;
use Illuminate\Validation\Rule;

class OrderRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_contains_valid_rules()
    {
        $r = new OrderRequest();

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
        ], $r->rules());
    }
}
