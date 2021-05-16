<?php

namespace Modules\Exercise08\Tests\Unit\Requests;

use Modules\Exercise08\Http\Requests\CalculateRequest;
use Tests\TestCase;

class CalculateRequestTest extends TestCase
{
    public function test_it_contains_valid_rules()
    {
        $r = new CalculateRequest();

        $this->assertEquals([
            'name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
            'booking_date' => 'required|date',
        ], $r->rules());
    }
}
