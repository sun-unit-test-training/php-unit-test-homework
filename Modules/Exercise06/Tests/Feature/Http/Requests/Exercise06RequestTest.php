<?php

namespace Modules\Tests\Exercise06\Tests\Http\Request;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Tests\TestCase;

class Exercise06RequestTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new Exercise06Request();
    }

    /**
     * @dataProvider providerData
     */
    public function testRules($data, $testCase = 'NG')
    {
        $validator = Validator::make($data, $this->request->rules());

        if ($testCase == 'OK') {
            $this->assertTrue($validator->passes());
        } else {
            $this->assertTrue($validator->fails());
        }
    }

    public function providerData()
    {
        return [
            [['bill' => null, 'has_watch' => null]],
            [['bill' => -1, 'has_watch' => null]],
            [['bill' => 1, 'has_watch' => 123]],
            [['bill' => 'string', 'has_watch' => true]],
            [['bill' => 1, 'has_watch' => true], 'OK'],
        ];
    }
}
