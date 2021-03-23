<?php

namespace Modules\Exercise08\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise08\Http\Requests\CalculateRequest;

class CalculateRequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new CalculateRequest();
    }

    public function test_name_invalid_required()
    {
        $input = [
            'name' => null,
            'age' => 15,
            'gender' => 'male',
            'booking_date' => '02/03/2021',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_age_invalid_required()
    {
        $input = [
            'name' => 'Hieu',
            'age' => null,
            'gender' => 'male',
            'booking_date' => '02/03/2021',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_gender_invalid_required()
    {
        $input = [
            'name' => 'Hieudt',
            'age' => 15,
            'gender' => null,
            'booking_date' => '02/03/2021',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_booking_date_invalid_required()
    {
        $input = [
            'name' => null,
            'age' => 15,
            'gender' => 'male',
            'booking_date' => null,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_age_invalid_integer()
    {
        $input = [
            'name' => 'Hieu',
            'age' => 'String',
            'gender' => 'male',
            'booking_date' => '02/03/2021',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_booking_date_invalid_date()
    {
        $input = [
            'name' => null,
            'age' => 15,
            'gender' => 'male',
            'booking_date' => 'String',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_input_valid()
    {
        $input = [
            'name' => 'Hieu',
            'age' => 15,
            'gender' => 'male',
            'booking_date' => '02/03/2021',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertTrue($validator->passes());
    }
}
