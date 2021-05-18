<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $checkoutRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutRequest = new CheckoutRequest();
    }

    /**
     * @dataProvider provider_test_validation_fail
     */
    public function test_validation_fail($input)
    {
        $validator = Validator::make($input, $this->checkoutRequest->rules());

        $this->assertTrue($validator->fails());
    }

    function provider_test_validation_fail()
    {
        return [
            [
                [
                    'total_products' => null,
                ]
            ],
            [
                [
                    'total_products' => '',
                ]
            ],
            [
                [
                    'total_products' => [
                        1 => 'abc'
                    ],
                ]
            ],
            [
                [
                    'total_products' => [
                        1 => -1
                    ],
                ]
            ],
        ];
    }

    public function test_validation_success()
    {
        $validator = Validator::make([
            'total_products' => [
                rand(0, 100),
            ],
        ], $this->checkoutRequest->rules());

        $this->assertFalse($validator->fails());
    }
}
