<?php

namespace Tests\Feature;

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
}
