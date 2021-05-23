<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Tests\TestCase;

class Exercise06RequestTest extends TestCase
{
    protected $exercise06Request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exercise06Request = new Exercise06Request();
    }

    /**
     * @dataProvider provider_input_fail
     */
    public function test_validation_fail($attribute, $input)
    {
        $validator = Validator::make($input, $this->exercise06Request->rules());

        $this->assertTrue($validator->fails());
    }

    public function provider_input_fail()
    {
        return [
            [
                [],
                [
                    'bill' => '',
                ],
                [
                    'bill' => null,
                ],
                [
                    'bill' => 'abc',
                ],
                [
                    'bill' => -1,
                ],
            ]
        ];
    }

    public function test_validate_success()
    {
        $input = [
            'bill' => 1000,
            'has_watch' => true,
        ];

        $validator = Validator::make($input, $this->exercise06Request->rules());
        $this->assertTrue($validator->passes());
    }
}