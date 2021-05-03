<?php

namespace Modules\Exercise10\Tests;

use Modules\Exercise10\Http\Requests\PrepaidRequest;
use Tests\TestCase;

class PrepaidRequestTest extends TestCase
{
    public function test_rules()
    {
        $request = new PrepaidRequest();
        $this->assertEquals([
            'type' => 'required|in:' . implode(',', config('exercise10.card_type')),
            'price' => 'required|integer',
            'ballot' => 'boolean'
        ], $request->rules());
    }
}
