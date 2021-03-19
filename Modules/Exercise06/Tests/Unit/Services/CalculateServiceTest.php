<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use InvalidArgumentException;
use Modules\Exercise06\Services\CalculateService;

class CalculateServiceTest extends TestCase
{
    protected $calculateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateService = new CalculateService();
    }

    /**
     * Test calculate function with bill < 0
     *
     * @expectedException InvalidArgumentException
     */
    public function test_calculate_with_bill_is_less_than_zero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculateService->calculate(-1);
    }

    /**
     * Test calculate function with bill = 0
     *
     * @expectedException InvalidArgumentException
     */
    public function test_calculate_with_bill_is_equal_to_zero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculateService->calculate(0);
    }

    /**
     * Test calculate function with bill = minBill2 and hasWatch = false
     *
     * @return void
     */
    public function test_calculate_with_bill_is_equal_to_min_bill_2_and_has_watch_false()
    {
        $response = $this->calculateService->calculate(5000);
        $this->assertEquals(120, $response);
    }

    /**
     * Test calculate function with bill = minBill2 and hasWatch = true
     *
     * @return void
     */
    public function test_calculate_with_bill_is_equal_to_min_bill_2_and_has_watch_true()
    {
        $response = $this->calculateService->calculate(5000, true);
        $this->assertEquals(300, $response);
    }

    /**
     * Test calculate function with bill > minBill2 and hasWatch = false
     *
     * @return void
     */
    public function test_calculate_with_bill_is_greater_than_min_bill_2_and_has_watch_false()
    {
        $response = $this->calculateService->calculate(5001);
        $this->assertEquals(120, $response);
    }

    /**
     * Test calculate function with bill > minBill2 and hasWatch = true
     *
     * @return void
     */
    public function test_calculate_with_bill_is_greater_than_min_bill_2_and_has_watch_true()
    {
        $response = $this->calculateService->calculate(5001, true);
        $this->assertEquals(300, $response);
    }

    /**
     * Test calculate function with bill = minBill1 and hasWatch = false
     *
     * @return void
     */
    public function test_calculate_with_bill_is_equal_to_min_bill_1_and_has_watch_false()
    {
        $response = $this->calculateService->calculate(2000);
        $this->assertEquals(60, $response);
    }

    /**
     * Test calculate function with bill = minBill1 and hasWatch = true
     *
     * @return void
     */
    public function test_calculate_with_bill_is_equal_to_min_bill_1_and_has_watch_true()
    {
        $response = $this->calculateService->calculate(2000, true);
        $this->assertEquals(240, $response);
    }

    /**
     * Test calculate function with bill > minBill1 and hasWatch = false
     *
     * @return void
     */
    public function test_calculate_with_bill_is_greater_than_min_bill_1_and_has_watch_false()
    {
        $response = $this->calculateService->calculate(2001);
        $this->assertEquals(60, $response);
    }

    /**
     * Test calculate function with bill > minBill1 and hasWatch = true
     *
     * @return void
     */
    public function test_calculate_with_bill_is_greater_than_min_bill_1_and_has_watch_true()
    {
        $response = $this->calculateService->calculate(2001, true);
        $this->assertEquals(240, $response);
    }

    /**
     * Test calculate function with bill < minBill1 and hasWatch = false
     *
     * @return void
     */
    public function test_calculate_with_bill_is_less_than_min_bill_1_and_has_watch_false()
    {
        $response = $this->calculateService->calculate(1999);
        $this->assertEquals(0, $response);
    }

    /**
     * Test calculate function with bill < minBill1 and hasWatch = true
     *
     * @return void
     */
    public function test_calculate_with_bill_is_less_than_min_bill_1_and_has_watch_true()
    {
        $response = $this->calculateService->calculate(1999, true);
        $this->assertEquals(180, $response);
    }
}
