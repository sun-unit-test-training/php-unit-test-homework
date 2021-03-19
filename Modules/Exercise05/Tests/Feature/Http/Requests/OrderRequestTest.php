<?php
namespace Modules\Exercise05\Tests\Feature\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    protected $orderRequest;

    public function setup(): void
    {
        parent::setup();
        $this->orderRequest = new OrderRequest();
    }

    public function test_validate_success()
    {
        $input = [
            'price' => 1000,
            'option_receive' => 1,
            'option_coupon' => 2,
        ];

        $validator = Validator::make($input, $this->orderRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_validate_fail_by_price()
    {
        $input = [
            'price' => -1000,
            'option_receive' => 1,
            'option_coupon' => 2,
        ];

        $validator = Validator::make($input, $this->orderRequest->rules());
        $this->assertTrue($validator->fails());
    }

    public function test_validate_fail_by_option_receive()
    {
        $input = [
            'price' => 1000,
            'option_receive' => 9,
            'option_coupon' => 2,
        ];

        $validator = Validator::make($input, $this->orderRequest->rules());
        $this->assertTrue($validator->fails());
    }

    public function test_validate_fail_by_option_coupon()
    {
        $input = [
            'price' => 1000,
            'option_receive' => 1,
        ];

        $validator = Validator::make($input, $this->orderRequest->rules());
        $this->assertTrue($validator->fails());
    }
}