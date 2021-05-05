<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
                'product_1' => 1,
                'product_2' => 11,
                'product_3' => 111,
            ],
        ];

        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_validate_with_totals_product_error()
    {
        $input = ['total_product' => 'test'];
        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('total_products', $validator->getMessageBag()->getMessages());
    }
}
