<?php

namespace Modules\Exercise06\Tests;

use Modules\Exercise06\Http\Requests\Exercise06Request;
use Tests\TestCase;

class Exercise06RequestTest extends TestCase
{
    public function test_rules()
    {
        $request = new Exercise06Request();
        $this->assertEquals([
            'bill' => 'required|integer|min:0',
            'has_watch' => 'nullable|boolean',
        ], $request->rules());
    }
}
