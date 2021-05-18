<?php

namespace Modules\Exercise07\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

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
    public function test_validation_fail($input)
    {
        $validator = Validator::make($input, $this->orderRequest->rules());

        $this->assertTrue($validator->fails());
    }

    function provider_test_validation_fail()
    {
        return [
            [
                [],
                [
                    'amount' => ''
                ],
                [
                    'amount' => null,
                ],
                [
                    'amount' => 'abc',
                ],
                [
                    'amount' => 0,
                ],
            ]
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
