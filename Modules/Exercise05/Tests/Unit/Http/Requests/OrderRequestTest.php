<?php

namespace Modules\Exercise05\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $orderRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRequest = new OrderRequest();
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
            [[]],
            [
                [
                    'price' => '',
                    'option_receive' => '',
                    'option_coupon' => '',
                ]
            ],
            [
                [
                    'price' => null,
                    'option_receive' => null,
                    'option_coupon' => null,
                ]
            ],
            [
                [
                    'price' => 'abc',
                    'option_receive' => 3,
                    'option_coupon' => 3,
                ]
            ],
        ];
    }

    public function test_validation_success()
    {
        $validator = Validator::make([
            'price' => rand(1, 100),
            'option_receive' => config('exercise05.receive_at_store'),
            'option_coupon' => config('exercise05.no_coupon'),
        ], $this->orderRequest->rules());

        $this->assertFalse($validator->fails());
    }
}
