<?php

namespace Modules\Exercise07\Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;

class CheckoutRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_it_contain_default_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'amount' => ['required', 'integer', 'min:1'],
        ], $request->rules());
    }

    /**
     * @dataProvider provider_test_validation_wrong
     */
    public function test_validation_fails_when_data_wrong($input)
    {
        $request = new CheckoutRequest();

        $validator = Validator::make([
            'amount' => $input['amount'],
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }

    function provider_test_validation_wrong()
    {
        return [
            [
                [
                    'amount' => null,
                ]
            ],
            [
                [
                    'amount' => 0,
                ]
            ],
            [
                [
                    'amount' => 0.5,
                ]
            ],
            [
                [
                    'amount' => 10.5,
                ]
            ],
        ];
    }

    public function test_validation_success()
    {
        $request = new CheckoutRequest();
        $validator = Validator::make([
            'amount' => 10,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
