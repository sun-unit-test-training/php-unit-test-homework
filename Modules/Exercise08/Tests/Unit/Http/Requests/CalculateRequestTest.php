<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Tests\TestCase;

class CalculateRequestTest extends TestCase
{
    protected $calculateRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calculateRequest = new CalculateRequest();
    }

    public function test_validate_success()
    {
        $input = [
            'name' => 'Test Name',
            'age' => 20,
            'gender' => 'male',
            'booking_date' => Carbon::now()
        ];

        $validator = Validator::make($input, $this->calculateRequest->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider provider_input_errors
     */
    public function test_validation_failed($attribute, $input)
    {
        $validator = Validator::make($input, $this->calculateRequest->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey($attribute, $validator->getMessageBag()->getMessages());
    }

    public function provider_input_errors()
    {
        return [
            [
                'name',
                [
                    'age' => 20,
                    'gender' => 'male',
                    'booking_date' => Carbon::now()
                ]
            ],
            [
                'age',
                [
                    'name' => 'Test name',
                    'gender' => 'male',
                    'booking_date' => Carbon::now()
                ]
            ],
            [
                'age',
                [
                    'name' => 'Test name',
                    'age' => 'age',
                    'gender' => 'male',
                    'booking_date' => Carbon::now()
                ]
            ],
            [
                'gender',
                [
                    'age' => 20,
                    'booking_date' => Carbon::now()
                ]
            ],
            [
                'booking_date',
                [
                    'name' => 'Test name',
                    'age' => 'age',
                    'gender' => 'male',
                ]
            ]
        ];
    }
}
