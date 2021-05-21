<?php

namespace Tests\Unit\Services;

use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class CalculateServiceTest extends TestCase
{
    protected $calculateService;

    protected function setUp(): void
    {
        parent::setup();

        $this->calculateService = new CalculateService();
    }

    public function test_calculate_return_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculateService->calculate(-1);
    }

    /**
     * @dataProvider provider_input_for_calculate
     */
    public function test_calculate_return_success($input, $time)
    {
        $result = $this->calculateService->calculate($input['bill'], $input['hasWatch'] ?? false);

        $this->assertEquals($result, $time);
    }

    public function provider_input_for_calculate()
    {
        list($minBill1, $freeTime1) = CalculateService::CASE_1;
        list($minBill2, $freeTime2) = CalculateService::CASE_2;
        $extraTime = CalculateService::FREE_TIME_FOR_MOVIE;

        return [
            [
                [
                    'bill' => 1000,
                    'hasWatch' => false,
                ],
                0
            ],
            [
                [
                    'bill' => 2000,
                    'hasWatch' => false,
                ],
                $freeTime1
            ],
            [
                [
                    'bill' => 2000,
                    'hasWatch' => true,
                ],
                $freeTime1 + $extraTime
            ],
            [
                [
                    'bill' => 5000,
                    'hasWatch' => false,
                ],
                $freeTime2
            ],
            [
                [
                    'bill' => 5000,
                    'hasWatch' => true,
                ],
                $freeTime2 + $extraTime
            ],
        ];
    }
}