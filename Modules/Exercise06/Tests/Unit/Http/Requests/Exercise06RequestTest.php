<?php

namespace Modules\Exercise06\Tests\Unit\Http\Requests;

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
     * @dataProvider provide_wrong_bill
     * @dataProvider provide_wrong_has_watch
     * 
     */
    public function test_validation_failure($attribute, $input)
    {
        $validator = Validator::make($input, $this->exercise06Request->rules());

        $this->assertTrue($validator->fails());
    }

    public function provide_wrong_bill()
    {
        return [
            [
                [],
                [
                    'bill' => null,
                ],
                [
                    'bill' => '',
                ],
                [
                    'bill' => 'string',
                ],
                [
                    'bill' => 1.2,
                ],
                [
                    'bill' => -1,
                ],
            ]
        ];
    }

    function provide_wrong_has_watch()
    {
        return [
            [
                [],
                [
                    'has_watch' => null,
                ],
                [
                    'has_watch' => '',
                ],
                [
                    'has_watch' => 'string',
                ],
                [
                    'has_watch' => 1.2,
                ],
                [
                    'has_watch' => 2,
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
