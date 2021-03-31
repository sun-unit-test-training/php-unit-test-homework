<?php

namespace Modules\Exercise07\Tests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;

class CheckoutRequestTest extends TestCase
{
    protected $checkoutRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->checkoutRequest = new CheckoutRequest();
    }

    public function test_amount_valid()
    {
        $input = [
            'amount' => 200,
        ];

        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_amount_zezo()
    {
        $input = [
            'amount' => 0,
        ];

        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_amount_empty()
    {
        $input = [
            'amount' => '',
        ];

        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_amount_null()
    {
        $input = [
            'amount' => null,
        ];

        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_amount_not_number()
    {
        $input = [
            'amount' => 'test',
        ];

        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertFalse($validator->passes());
    }
}
