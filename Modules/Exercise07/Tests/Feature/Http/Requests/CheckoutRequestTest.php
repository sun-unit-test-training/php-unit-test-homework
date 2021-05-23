<?php

namespace Modules\Tests\Exercise07\Tests\Http\Request;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new CheckoutRequest();
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
            [['amount' => null]],
            [['amount' => 0]],
            [['amount' => 'string']],
            [['amount' => '1'], 'OK'],
        ];
    }
}
