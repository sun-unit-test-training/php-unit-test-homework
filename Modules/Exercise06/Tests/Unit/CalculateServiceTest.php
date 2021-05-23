<?php

namespace Modules\Exercise06\Tests\Unit;

use InvalidArgumentException;
use Tests\TestCase;
use Modules\Exercise06\Services\CalculateService;

class CalculateServiceTest extends TestCase
{
    private $calculateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateService = new CalculateService();
    }

    public function providerBillLteqZero()
    {
        return [
            [0],
            [-100],
        ];
    }

    /**
     * @dataProvider providerBillLteqZero
     */
    public function test_exception_when_bill_lessthan_or_equal_zero($bill)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->calculateService->calculate($bill);
    }

    public function providerValidData()
    {
        return [
            [6000, false, 120],
            [5000, false, 120],
            [4000, false, 60],
            [2000, false, 60],
            [1000, false, 0],
            [6000, true, 300],
            [5000, true, 300],
            [4000, true, 240],
            [2000, true, 240],
            [1000, true, 180],
        ];
    }

    /**
     * @dataProvider providerValidData
     */
    public function test_caculate_bill($bill, $hasWatch, $time)
    {
        $result = $this->calculateService->calculate($bill, $hasWatch, $time);

        $this->assertEquals($time, $result);
    }
}
