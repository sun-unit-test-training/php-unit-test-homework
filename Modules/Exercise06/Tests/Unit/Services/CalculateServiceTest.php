<?php

namespace Modules\Exercise06\Tests\Unit\Services;

use Tests\TestCase;
use InvalidArgumentException;
use Modules\Exercise06\Services\CalculateService;

class CalculateServiceTest extends TestCase
{
    protected $calculateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateService = new CalculateService;
    }

    public function test_calculate_before_min_total_bill_without_watch()
    {
        $bill = 1999;
        $hasWatch = false;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(0, $times);
    }

    public function test_calculate_min_total_bill_without_watch()
    {
        $bill = 2000;
        $hasWatch = false;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(60, $times);
    }

    public function test_calculate_in_total_bill_without_watch()
    {
        $bill = 2001;
        $hasWatch = false;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(60, $times);
    }

    public function test_calculate_before_min_total_bill_five_without_watch()
    {
        $bill = 4999;
        $hasWatch = false;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(60, $times);
    }

    public function test_calculate_min_total_bill_five_without_watch()
    {
        $bill = 5000;
        $hasWatch = false;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(120, $times);
    }

    public function test_calculate_in_total_bill_five_without_watch()
    {
        $bill = 5001;
        $hasWatch = false;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(120, $times);
    }

    public function test_calculate_before_min_total_bill_with_watch()
    {
        $bill = 1999;
        $hasWatch = true;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(180, $times);
    }

    public function test_calculate_min_total_bill_with_watch()
    {
        $bill = 2000;
        $hasWatch = true;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(240, $times);
    }

    public function test_calculate_in_total_bill_with_watch()
    {
        $bill = 2001;
        $hasWatch = true;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(240, $times);
    }

    public function test_calculate_before_min_total_bill_five_with_watch()
    {
        $bill = 4999;
        $hasWatch = true;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(240, $times);
    }

    public function test_calculate_min_total_bill_five_with_watch()
    {
        $bill = 5000;
        $hasWatch = true;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(300, $times);
    }

    public function test_calculate_in_total_bill_five_with_watch()
    {
        $bill = 5001;
        $hasWatch = true;
        $times = $this->calculateService->calculate($bill, $hasWatch);

        $this->assertEquals(300, $times);
    }

    public function test_total_bill_zero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Bill must be greater than 0');
        $bill = 0;
        $this->calculateService->calculate($bill);
    }

    public function test_total_bill_less_than_zero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Bill must be greater than 0');
        $bill = -1;
        $this->calculateService->calculate($bill);
    }
}
