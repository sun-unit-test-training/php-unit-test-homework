<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Exercise03\Models\Product;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;

class Exercise03RequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new CheckoutRequest();
    }

    public function test_total_product_valid()
    {
        $input['total_products'] = [
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 5,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * Test fail validation
     *
     * @dataProvider providerFailValidate
     *
     * @return void
     */
    public function test_validate_fail($originalString)
    {
        $validator = Validator::make($originalString, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    /**
     * Provider fail validation
     *
     * @return array
     */
    public function providerFailValidate()
    {
        return [
            [
                [
                    'total_products' => [
                        Product::CRAVAT_TYPE => 'a-say-zo'
                    ],
                ],
            ],
            [
                [
                    'total_products' => [
                        Product::CRAVAT_TYPE => -1
                    ],
                ],
            ],
            [
                [
                    'total_products' => [
                        Product::CRAVAT_TYPE => 'ahihi'
                    ],
                ],
            ],
            [
                [
                    'total_products' => [],
                ],
            ],
            [
                [],
            ],
        ];
    }
}
