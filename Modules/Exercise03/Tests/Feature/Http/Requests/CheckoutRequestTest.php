<?php

namespace Modules\Tests\Exercise03\Tests\Feature\Http\Requests;

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

    public function testRules()
    {
        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ],
            $this->request->rules()
        );
    }

    public function testInvalidData()
    {
        $validator = Validator::make([], $this->request->rules());
        $this->assertTrue($validator->fails());
    }

    public function testValidData()
    {
        $data = [
            'total_products' => [0, 1, 2, 3],
        ];

        $validator = Validator::make($data, $this->request->rules());
        $this->assertTrue($validator->passes());
    }
}
