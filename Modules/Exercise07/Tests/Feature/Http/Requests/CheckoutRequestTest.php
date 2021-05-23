<?php

namespace Modules\Exercise07\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;
use Illuminate\Support\Arr;

class CheckoutRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $orderRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRequest = new CheckoutRequest();
    }

    /**
     * @dataProvider provider_test_validation_fail
     */
    public function test_validation_fail($key, $value)
    {
        $request = new CheckoutRequest();
        $validator = Validator::make($value, $request->rules());

        $this->assertTrue(Arr::exists($validator->errors()->messages(), $key));
    }

    function provider_test_validation_fail()
    {
        return [
            [
                'amount', [
                    'amount' => null,
                    'premium_member' => true,
                ]
            ],
            [
                'amount', [
                    'amount' => 1.1,
                    'shipping_express' => true,
                ]
            ],
            [
                'amount', [
                    'amount' => 0,
                    'shipping_express' => false,
                    'premium_member' => false
                ]
            ],
        ];
    }

    public function test_validation_success()
    {
        $validator = Validator::make([
            'amount' => rand(1, 100),
        ], $this->orderRequest->rules());

        $this->assertFalse($validator->fails());
    }
}