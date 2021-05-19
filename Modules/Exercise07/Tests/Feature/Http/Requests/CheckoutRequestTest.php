<?php

namespace Modules\Exercise07\Tests\Feature\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    public function test_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'amount' => ['required', 'integer', 'min:1'],
        ], $request->rules());
    }

    public function test_validation_fails_when_data_empty()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'amount' => null,
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }

    public function test_validation_success()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'amount' => 99,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
