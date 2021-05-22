<?php

namespace Modules\Exercise06\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Tests\SetupDatabaseTrait;
use Illuminate\Support\Arr;

class Exercise06RequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_contain_default_rules()
    {
        $request = new Exercise06Request();

        $this->assertEquals([
            'bill' => 'required|integer|min:0',
            'has_watch' => 'nullable|boolean',
        ], $request->rules());
    }
}
