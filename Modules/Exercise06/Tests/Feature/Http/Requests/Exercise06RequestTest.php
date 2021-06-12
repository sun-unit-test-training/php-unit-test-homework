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

    public function test_it_contain_default_rules()
    {
        $request = new Exercise06Request();

        $this->assertEquals([
            'bill' => 'required|integer|min:0',
            'has_watch' => 'nullable|boolean',
        ], $request->rules());
    }

    /**
     * @dataProvider provideWrongBill
     * @dataProvider provideWrongHasWatch
     */
    public function test_validation_fails_when_input_invalid($fieldError, $input)
    {
        $request = new Exercise06Request();
        $validator = Validator::make($input, $request->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $fieldError));
    }

    function provideWrongBill()
    {
        return [
            [
                'bill', [
                    'bill' => null,
                    'has_watch' => true,
                ]
            ],
            [
                'bill', [
                    'bill' => 1.1,
                    'has_watch' => true,
                ]
            ],
            [
                'bill', [
                    'bill' => -1,
                    'has_watch' => true,
                ]
            ],
        ];
    }

    function provideWrongHasWatch()
    {
        return [
            [
                'has_watch', [
                    'bill' => 1,
                    'has_watch' => 2,
                ]
            ]
        ];
    }

    public function test_validation_success()
    {
        $request = new Exercise06Request();
        $validator = Validator::make([
            'bill' => 1,
            'has_watch' => null,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
