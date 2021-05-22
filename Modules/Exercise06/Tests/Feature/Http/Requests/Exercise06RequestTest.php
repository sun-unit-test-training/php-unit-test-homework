<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Tests\TestCase;

class Exercise06RequestTest extends TestCase
{
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new Exercise06Request();
    }

    public function test_validate_success()
    {
        $input = [
            'bill' => 1,
            'has_watch' => false,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider provider_input
     * @param $input
     */
    public function test_validation_failed($input)
    {
        $validator = Validator::make($input, $this->request->rules());

        $this->assertTrue($validator->fails());
    }

    public function provider_input()
    {
        return [
            [
                [],
                [
                    'has_watch' => true,
                ],
                [
                    'bill' => 1.2,
                ],
                [
                    'bill' => 1200,
                    'has_watch' => 'test',
                ],
            ]
        ];
    }
}
