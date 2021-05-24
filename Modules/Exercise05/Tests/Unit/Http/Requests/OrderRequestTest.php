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

    /**
     * @dataProvider provide_wrong_price
     * @dataProvider provide_wrong_option_receive
     * @dataProvider provide_wrong_option_coupon
     */
    public function test_validation_failure($attribute, $inputs)
    {
        $validator = Validator::make($inputs, $this->orderRequest->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey($attribute, $validator->getMessageBag()->getMessages());
    }

    
    function provide_wrong_price()
    {
        return [
            [
                'price', [
                    'price' => null,
                    'option_receive' => 1,
                    'option_coupon' => 1
                ]
            ],
            [
                'price', [
                    'price' => 'test price wrong',
                    'option_receive' => 1,
                    'option_coupon' => 1
                ]
            ],
        ];
    }

    function provide_wrong_option_receive()
    {
        return [
            [
                'option_receive', [
                    'price' => 1,
                    'option_receive' => null,
                    'option_coupon' => 1
                ]
            ],
            [
                'option_receive', [
                    'price' => 1,
                    'option_receive' => 0,
                    'option_coupon' => 1
                ]
            ]
        ];
    }

    function provide_wrong_option_coupon()
    {
        return [
            [
                'option_coupon', [
                    'price' => 1,
                    'option_receive' => 1,
                    'option_coupon' => null
                ]
            ],
            [
                'option_coupon', [
                    'price' => 1,
                    'option_receive' => 1,
                    'option_coupon' => 0
                ]
            ]
        ];
    }

   

    public function test_validation_success()
    {
        $validator = Validator::make([
                'price' => 100,
                'option_receive' => 1,
                'option_coupon' => 2
            ], $this->orderRequest->rules());

        $this->assertTrue($validator->passes());
    }
}
