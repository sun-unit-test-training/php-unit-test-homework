<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use \App\Http\Controllers;

class Exercise08ControllerTest extends TestCase
{
    protected $exercise08Controller;
    /**
     * @throws \Exception
     */

    public function setUp():void
    {
        parent::setUp();

        $this->exercise08Controller = new Controllers\Exercise08Controller();
    }

    // functions test with rule in decision table

    public function test_calculate_discount_with_rule_1()
    {
        $age = 12;
        $date = '2021-05-01';
        $gender = 'male';
        $result = $this->exercise08Controller->calculatePrice($age, $date, $gender);
        $this->assertEquals(900, $result);
    }

    public function test_calculate_discount_with_rule_2()
    {
        $age = 14;
        $date = '2021-04-20';
        $gender = 'male';
        $result = $this->exercise08Controller->calculatePrice($age, $date, $gender);
        $this->assertEquals(1200, $result);
    }

    public function test_calculate_discount_with_rule_3()
    {
        $age = 14;
        $date = '2021-04-30';
        $gender = 'female';
        $result = $this->exercise08Controller->calculatePrice($age, $date, $gender);
        $this->assertEquals(1400, $result);
    }

    public function test_calculate_discount_with_rule_4()
    {
        $age = 14;
        $date = '2021-04-30';
        $gender = 'male';
        $result = $this->exercise08Controller->calculatePrice($age, $date, $gender);
        $this->assertEquals(1800, $result);
    }

    public function test_calculate_discount_with_rule_5()
    {
        $age = 66;
        $date = '2021-04-30';
        $gender = 'male';
        $result = $this->exercise08Controller->calculatePrice($age, $date, $gender);
        $this->assertEquals(1600, $result);
    }

    public function test_calculate_discount_with_rule_6()
    {
        $age = 20;
        $date = '2021-05-01';
        $gender = 'female';
        $result = $this->exercise08Controller->calculatePrice($age, $date, $gender);
        $this->assertEquals(1800, $result);
    }

    public function test_calculate_discount_with_case_age_invalid()
    {
        $age = 150;
        $date = '2021-05-01';
        $gender = 'female';
        $result = $this->exercise08Controller->calculatePrice($age, $date, $gender);
        $this->assertEquals("Error", $result);
    }
}