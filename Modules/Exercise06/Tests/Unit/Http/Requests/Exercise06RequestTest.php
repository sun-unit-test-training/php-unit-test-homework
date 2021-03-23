<?php

namespace Modules\Exercise06\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;

class Exercise06RequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new Exercise06Request();
    }

    public function test_bill_valid()
    {
        $input = [
            'bill' => 5000
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_bill_invalid_required()
    {
        $input = [];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_bill_invalid_integer()
    {
        $input = [
            'bill' => 'ABC'
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }
    
    public function test_bill_invalid_before_min_zero()
    {
        $input = [
            'bill' => -1
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_bill_valid_min_zero()
    {
        $input = [
            'bill' => 0
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_watch_boolean_valid()
    {
        $input = [
            'bill' => '5000',
            'has_watch' => false,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_watch_boolean_invalid()
    {
        $input = [
            'bill' => '5000',
            'has_watch' => 'false',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }
}
