<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    protected $orderRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRequest = new OrderRequest();
    }

    public function test_validate_success()
    {
        $input = [
            'price' => 2000,
            'option_receive' => config('exercise05.receive_at_store'),
            'option_coupon' => config('exercise05.no_coupon')
        ];

        $validator = Validator::make($input, $this->orderRequest->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider provider_input_errors
     */
    public function test_validation_failed($attribute, $inputs)
    {
        $validator = Validator::make($inputs, $this->orderRequest->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey($attribute, $validator->getMessageBag()->getMessages());
    }

    public function provider_input_errors()
    {
        return [
            //invalid price
            [
                'price',
                [
                    'price' => '',
                    'option_receive' => 1,
                    'option_coupon' => 1
                ]
            ],
            [
                'price',
                [
                    'price' => 'test',
                    'option_receive' => 1,
                    'option_coupon' => 1
                ]
            ],

            //invalid option_receive
            [
                'option_receive',
                [
                    'price' => 1200,
                    'option_receive' => 0,
                    'option_coupon' => 1
                ]
            ],

            //invalid option_coupon
            [
                'option_coupon',
                [
                    'price' => 1200,
                    'option_receive' => 1,
                    'option_coupon' => 0
                ]
            ],
        ];
    }
}
