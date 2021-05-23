<?php

namespace Modules\Exercise07\Tests\Unit\Http\Request;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutRequestTest extends TestCase
{
    protected $request;
    public function setUp(): void
    {
        parent::setUp();
        $this->request = new CheckoutRequest();
    }

    public function test_rules()
    {
        $this->assertEquals([
            'amount' => ['required', 'integer', 'min:1'],
        ], $this->request->rules());
    }

    /**
     * @dataProvider provide_input_data
     */
    public function test_validation_fails($input)
    {
        $validator = Validator::make([
            'amount' => $input['amount'],
        ], $this->request->rules());

        $this->assertTrue($validator->fails());
    }

    public function provide_input_data()
    {
        return [
            [
                [
                    'amount' => null,
                ]
            ],
            [
                [
                    'amount' => -1,
                ]
            ],
            [
                [
                    'amount' => 5.5,
                ]
            ],
        ];
    }

    public function test_validation_pass()
    {
        $validator = Validator::make([
            'amount' => 10000,
        ], $this->request->rules());

        $this->assertTrue($validator->passes());
    }
}
