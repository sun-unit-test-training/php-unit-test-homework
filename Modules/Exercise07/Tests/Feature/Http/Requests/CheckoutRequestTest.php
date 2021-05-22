<?php

namespace Modules\Exercise07\Tests\Feature\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CheckoutRequest();
    }

    /**
     * @dataProvider provider_input_fail
     * @param $input
     */
    public function test_validation_fails($input)
    {
        $validator = Validator::make($input, $this->request->rules());

        $this->assertTrue($validator->fails());
    }

    public function provider_input_fail()
    {
        return [
            [
                [
                    'amount' => 0,
                ],
                [],
                [
                    'amount' => 1,2,
                ],
                [
                    'amount' => '',
                ],
                [
                    'amount' => '#@$@#',
                ],
            ],
        ];
    }

    public function test_validation_success()
    {
        $validator = Validator::make([
            'amount' => 1,
        ], $this->request->rules());

        $this->assertTrue($validator->passes());
    }
}
