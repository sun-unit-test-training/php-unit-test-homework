<?php

namespace Modules\Exercise03\Tests\Feature\Http\Requests;


use Illuminate\Support\Facades\Validator;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new CheckoutRequest();
    }

    public function test_default_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0'
        ], $request->rules());
    }

    public function test_invalid_data()
    {
        $validator = Validator::make([], $this->request->rules());
        $this->assertTrue($validator->fails());
    }

    public function test_valid_data()
    {
        $data = [
            'total_products' => [0, 1, 2, 3],
        ];

        $validator = Validator::make($data, $this->request->rules());
        $this->assertTrue($validator->passes());
    }
}
