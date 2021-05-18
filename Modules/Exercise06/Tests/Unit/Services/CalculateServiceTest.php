<?php

namespace Modules\Exercise06\Tests\Unit\Services;

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
        $this->calculateService->calculate(0);
    }

    /**
     * @dataProvider provider_test_calculate
     */
    public function test_calculate($input, $expected)
    {
        $result = $this->calculateService->calculate($input['bill'], $input['hasWatch']);

        $this->assertEquals($result, $expected);
    }

    function provider_test_calculate()
    {
        list($minBill1, $freeTime1) = CalculateService::CASE_1;
        list($minBill2, $freeTime2) = CalculateService::CASE_2;
        $freeTime = CalculateService::FREE_TIME_FOR_MOVIE;

        return [
            [
                [
                    'bill' => $minBill2,
                    'hasWatch' => false,
                ],
                $freeTime2,
            ],
            [
                [
                    'bill' => $minBill2,
                    'hasWatch' => true,
                ],
                $freeTime2 + $freeTime,
            ],
            [
                [
                    'bill' => $minBill1,
                    'hasWatch' => false,
                ],
                $freeTime1,
            ],
            [
                [
                    'bill' => $minBill1,
                    'hasWatch' => true,
                ],
                $freeTime1 + $freeTime,
            ],
            [
                [
                    'bill' => 10,
                    'hasWatch' => true,
                ],
                $freeTime,
            ],
            [
                [
                    'bill' => 10,
                    'hasWatch' => false,
                ],
                0,
            ],
        ];
    }
}
