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

    public function testRules()
    {
        $request = new Exercise06Request();

        $this->assertEquals([
            'bill' => 'required|integer|min:0',
            'has_watch' => 'nullable|boolean',
        ], $request->rules());
    }

    public function testValidationSuccess()
    {
        $request = new Exercise06Request();
        $validator = Validator::make([
            'bill' => 1,
            'has_watch' => null,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider dataWrongBill
     * @dataProvider dataWrongWatchMovie
     */
    public function testValidationInvalid($key, $value)
    {
        $request = new Exercise06Request();
        $validator = Validator::make($value, $request->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $key));
    }

    function dataWrongBill()
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
                    'bill' => 69.96,
                    'has_watch' => true,
                ]
            ],
            [
                'bill', [
                    'bill' => -1,
                    'has_watch' => true,
                ]
            ],
            [
                'bill', []
            ],
        ];
    }

    function dataWrongWatchMovie()
    {
        return [
            [
                'has_watch', [
                    'bill' => 1,
                    'has_watch' => 3,
                ]
            ]
        ];
    }
}
