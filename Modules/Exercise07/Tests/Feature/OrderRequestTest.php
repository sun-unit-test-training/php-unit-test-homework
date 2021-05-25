<?php

namespace Modules\Exercise07\Tests\Feature;

use Tests\TestCase;
use Modules\Exercise07\Http\Requests\CheckoutRequest;

class CheckoutRequestTest extends TestCase
{
    public function test_rules()
    {
        $request = new CheckoutRequest();
        $this->assertEquals([
            'amount' => ['required', 'integer', 'min:1'],
        ], $request->rules());
    }
}
