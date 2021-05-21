<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    protected $checkoutRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutRequest = new CheckoutRequest();
    }

    public function test_validate_success()
    {
        $input = [
            'total_products' => [
                'product_1' => 0,
                'product_2' => 1
            ]
        ];

        $validator = Validator::make($input, $this->checkoutRequest->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider provider_test_validation_fail
     */
    public function test_validation_fail($attribute, $inputs)
    {
        $validator = Validator::make($inputs, $this->checkoutRequest->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey($attribute, $validator->getMessageBag()->getMessages());
    }

    function provider_test_validation_fail()
    {
        return [
            [
                'total_products',
                [
                    'total_products' => null,
                ]
            ],
            ['total_products',
                [
                    'total_products' => '',
                ]
            ],
        ];
    }

    /**
     * @dataProvider provider_test_integer_validation_fail
     */
    public function test_validation_fail_not_integer($attribute, $inputs)
    {
        $validator = Validator::make($inputs, $this->checkoutRequest->rules());
        $this->assertFalse($validator->passes());
        $attribute = $attribute.'.total_products_0';
        $this->assertArrayHasKey($attribute, $validator->getMessageBag()->getMessages());
    }

    function provider_test_integer_validation_fail()
    {
        return [
            [
                'total_products',
                [
                    'total_products' => [
                        'total_products_0' => '1x'
                    ],
                ]
            ],
            [
                'total_products',
                [
                    'total_products' => [
                        'total_products_0' => -1
                    ],
                ]
            ],
        ];
    }
}