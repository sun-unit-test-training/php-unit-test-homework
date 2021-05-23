<?php

namespace Modules\Exercise06\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Exercise06RequestTest extends TestCase
{
    protected $request;
    public function setUp(): void
    {
        parent::setUp();
        $this->request = new Exercise06Request();
    }

    public function test_rules()
    {
        $this->assertEquals([
            'bill' => 'required|integer|min:0',
            'has_watch' => 'nullable|boolean',
        ], $this->request->rules());
    }

    /**
     * @dataProvider provider_test_validation_wrong
     */
    public function test_validation_fails_when_data_wrong($input)
    {
        $validator = Validator::make([
            'bill' => $input['bill'],
            'has_watch' => $input['has_watch'],
        ], $this->request->rules());

        $this->assertTrue($validator->fails());
    }

    function provider_test_validation_wrong()
    {
        return [
            [
                [
                    'bill' => null,
                    'has_watch' => null,
                ]
            ],
            [
                [
                    'bill' => 10.1,
                    'has_watch' => null,
                ],
            ],
            [
                [
                    'bill' => -1,
                    'has_watch' => null
                ],
            ],
            [
                [
                    'bill' => 10,
                    'has_watch' => 'abc'
                ],
            ],
            [
                [
                    'bill' => 5.5,
                    'has_watch' => 'def'
                ],
            ],
        ];
    }

    public function test_validation_success()
    {
        $validator = Validator::make([
            'bill' => 1000,
            'has_watch' => true,
        ], $this->request->rules());

        $this->assertTrue($validator->passes());
    }
}
