<?php

namespace Modules\Exercise02\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Modules\Exercise02\Http\Requests\ATMRequest;

class ATMRequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new ATMRequest();
    }

    public function test_validate_fails()
    {
        $validator = Validator::make([], $this->request->rules());
        $this->assertTrue($validator->fails());
    }

    public function test_rules()
    {
        $rules = [
            'card_id' => 'required|exists:atms,card_id',
        ];
        $this->assertEquals($rules, $this->request->rules());
    }
}
