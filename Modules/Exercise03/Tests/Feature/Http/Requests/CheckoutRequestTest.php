<?php

namespace Modules\Exercise03\Tests\Unit\Requests;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    public function test_rules()
    {
        $request = new CheckoutRequest();

        $this->assertSame([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ], $request->rules());
    }

    public function test_validation_fails_when_data_empty()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([], $request->rules());

        $this->assertTrue($validator->fails());
    }

    public function test_validation_success()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'total_products' => [1 => 1, 2 => 2, 3 => 3],
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
