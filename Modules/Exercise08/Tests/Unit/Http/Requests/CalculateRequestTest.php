<?php

namespace Modules\Exercise08\Tests\Unit\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Tests\TestCase;

class CalculateRequestTest extends TestCase
{
    protected $request;
    protected $date;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->request = new CalculateRequest();
        $this->date = Carbon::now()->format('m/d/Y');
    }

    public function test_name_invalid_required()
    {
        $input = [
            'name' => '',
            'age' => 21,
            'gender' => 'male',
            'booking_date' => $this->date,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_age_invalid_required()
    {
        $input = [
            'name' => 'Quan',
            'gender' => 'male',
            'booking_date' => $this->date,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_gender_invalid_required()
    {
        $input = [
            'name' => 'Quan',
            'age' => 21,
            'booking_date' => $this->date,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_booking_date_invalid_required()
    {
        $input = [
            'name' => 'Quan',
            'age' => 21,
            'gender' => 'male',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_age_invalid_integer()
    {
        $input = [
            'name' => 'Quan',
            'age' => 'Tien',
            'gender' => 'male',
            'booking_date' => $this->date,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_booking_date_invalid_date()
    {
        $input = [
            'name' => 'Quan',
            'age' => 21,
            'gender' => 'male',
            'booking_date' => 'Tien',
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertFalse($validator->passes());
    }

    public function test_input_valid()
    {
        $input = [
            'name' => 'Quan',
            'age' => 21,
            'gender' => 'male',
            'booking_date' => $this->date,
        ];

        $validator = Validator::make($input, $this->request->rules());
        $this->assertTrue($validator->passes());
    }
}