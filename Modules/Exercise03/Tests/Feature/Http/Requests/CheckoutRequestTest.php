<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    protected $checkoutRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutRequest = new CheckoutRequest();
    }

    public function test_validate_success()
    {
        $input = [
            'total_products' => [
                1 => null,
                2 => 2,
                3 => 3,
            ],
        ];

        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_validate_with_totals_product_error()
    {
        $input = ['total_product' => 'fail'];
        $validator = Validator::make($input, $this->checkoutRequest->rules());

        $this->assertFalse($validator->passes());
    }
}
