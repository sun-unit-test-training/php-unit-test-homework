<?php

namespace Modules\Exercise06\Tests\Feature\Http\Requests;

use Illuminate\Support\Facades\Validator;
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

    public function test_validation_fails_when_data_empty()
    {
        $request = new Exercise06Request();
        $validator = Validator::make([
            'bill' => null,
            'has_watch' => 123,
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }

    public function test_validation_success()
    {
        $request = new Exercise06Request();
        $validator = Validator::make([
            'bill' => 99,
            'has_watch' => true,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
