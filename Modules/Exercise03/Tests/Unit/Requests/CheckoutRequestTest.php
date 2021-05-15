<?php

namespace Modules\Exercise03\Tests\Unit\Requests;

use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    public function test_it_contains_valid_rules()
    {
        $r = new CheckoutRequest();

        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ], $r->rules());
    }
}
