<?php

    namespace Modules\Exercise07\Tests\Unit\Http\Request;

    use Illuminate\Support\Facades\Validator;
    use Tests\TestCase;
    use Modules\Exercise07\Http\Requests\CheckoutRequest;

    class CheckoutRequestTest extends TestCase
    {
        protected $checkoutRequest;

        public function setUp(): void
        {
            parent::setUp();
            $this->checkoutRequest = new CheckoutRequest();
        }

        public function test_validate_with_amount_valid()
        {
            $input = [
                'amount' => 10
            ];

            $validator = Validator::make($input, $this->checkoutRequest->rules());
            $this->assertTrue($validator->passes());
        }

        public function test_amount_invalid_with_null()
        {
            $input = [
                'amount' => ''
            ];

            $validator = Validator::make($input, $this->checkoutRequest->rules());
            $this->assertFalse($validator->passes());
        }

        public function test_amount_invalid_with_string()
        {
            $input = [
                'amount' => 'amount'
            ];

            $validator = Validator::make($input, $this->checkoutRequest->rules());
            $this->assertFalse($validator->passes());
        }

        public function test_amount_invalid_with_zero()
        {
            $input = [
                'amount' => 0
            ];

            $validator = Validator::make($input, $this->checkoutRequest->rules());
            $this->assertFalse($validator->passes());
        }

    }
