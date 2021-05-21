<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_validate_success()
    {
        $input = [
            'bill' => 1000,
            'has_watch' => true,
        ];

        $validator = Validator::make($input, $this->exercise06Request->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider provider_input_errors
     */
    public function test_validation_failed($attribute, $input)
    {
        $validator = Validator::make($input, $this->exercise06Request->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey($attribute, $validator->getMessageBag()->getMessages());
    }

    public function provider_input_errors()
    {
        return [
            [
                'bill',
                [
                    'bill' => 'a'
                ]
            ],
            [
                'bill',
                [
                    'bill' => [],
                ]

            ],
            [
                'has_watch',
                [
                    'bill' => 100,
                    'has_watch' => 10
                ]
            ]
        ];
    }
}
