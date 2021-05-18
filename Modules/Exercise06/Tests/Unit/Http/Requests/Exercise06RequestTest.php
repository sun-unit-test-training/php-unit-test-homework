<?php

namespace Modules\Exercise06\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class Exercise06RequestTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $exerciseRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exerciseRequest = new Exercise06Request();
    }

    /**
     * @dataProvider provider_test_validation_fail
     */
    public function test_validation_fail($input)
    {
        $validator = Validator::make($input, $this->exerciseRequest->rules());

        $this->assertTrue($validator->fails());
    }

    function provider_test_validation_fail()
    {
        return [
            [
                [],
                [
                    'bill' => '',
                    'has_watch' => 'has_watch',
                ],
                [
                    'bill' => null,
                    'has_watch' => 'has_watch',
                ],
                [
                    'bill' => 'abc',
                    'has_watch' => 'has_watch',
                ],
                [
                    'bill' => -1,
                    'has_watch' => 'has_watch',
                ],
            ]
        ];
    }

    public function test_validation_success()
    {
        $validator = Validator::make([
            'bill' => rand(0, 10),
            'has_watch' => true,
        ], $this->exerciseRequest->rules());

        $this->assertFalse($validator->fails());
    }
}
