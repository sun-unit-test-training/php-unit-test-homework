<?php

namespace Modules\Exercise07\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Tests\SetupDatabaseTrait;

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
     * @dataProvider provider_test_validation_wrong
     */
    public function test_validation_fails_when_data_wrong($input)
    {
        $request = new Exercise06Request();

        $validator = Validator::make([
            'bill' => $input['bill'],
            'has_watch' => $input['has_watch'],
        ], $request->rules());

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
                    'bill' => 5.5,
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
                    'has_watch' => 10
                ],
            ],
            [
                [
                    'bill' => 5.5,
                    'has_watch' => 10
                ],
            ],
        ];
    }

    public function test_validation_success()
    {
        $request = new Exercise06Request();
        $validator = Validator::make([
            'bill' => 10,
            'has_watch' => true,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
