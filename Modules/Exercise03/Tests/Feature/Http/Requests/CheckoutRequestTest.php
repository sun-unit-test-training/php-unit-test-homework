<?php

namespace Modules\Exercise03\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Illuminate\Support\Arr;

class CheckoutRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $checkoutRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutRequest = new CheckoutRequest();
    }

    public function test_contains_valid_rules()
    {
        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0'
        ], $this->checkoutRequest->rules());
    }
}
