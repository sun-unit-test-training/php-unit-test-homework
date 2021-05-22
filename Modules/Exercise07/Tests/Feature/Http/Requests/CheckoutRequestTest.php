<?php

namespace Modules\Exercise07\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Illuminate\Support\Arr;

class CheckoutRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_contain_default_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'amount' => ['required', 'integer', 'min:1'],
        ], $request->rules());
    }
}
