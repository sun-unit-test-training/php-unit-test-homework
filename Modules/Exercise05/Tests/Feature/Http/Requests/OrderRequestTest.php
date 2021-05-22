<?php

namespace Modules\Exercise05\Tests\Feature\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderRequest();
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
                    'price' => '',
                    'option_receive' => 1,
                    'option_coupon' => 1
                ],
                [
                    'price' => '!@!#!',
                    'option_receive' => 1,
                    'option_coupon' => 1
                ],
                [
                    'price' => 1,
                    'option_receive' => 0,
                    'option_coupon' => 1
                ],
                [
                    'price' => 1,
                    'option_receive' => 1,
                    'option_coupon' => 0
                ]
            ],
        ];
    }

    public function test_validation_success()
    {
        $request = new OrderRequest();
        $validator = Validator::make([
            'price' => 1,
            'option_receive' => config('exercise05.receive_at_store'),
            'option_coupon' => config('exercise05.no_coupon')
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
