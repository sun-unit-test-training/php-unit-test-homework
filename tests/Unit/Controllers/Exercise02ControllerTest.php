<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use \App\Http\Controllers;

class Exercise02ControllerTest extends TestCase
{
    protected $exercise02Controller;

    /**
     * @throws \Exception
     */
    public function setUp():void
    {
        parent::setUp();

        $this->exercise02Controller = new Controllers\Exercise02Controller();
    }

    // functions test with rule in decision table

    public function test_charge_ATM_with_rule_1()
    {
        $result = $this->exercise02Controller->chargeATM(true);
        $this->assertEquals(0, $result);
    }

    public function test_charge_ATM_with_rule_2()
    {
        $result = $this->exercise02Controller->chargeATM(false, '2021-05-01');
        $this->assertEquals(110, $result);
    }

    public function test_charge_ATM_with_rule_3()
    {
        $result = $this->exercise02Controller->chargeATM(false, '2021-04-28', '14:25');
        $this->assertEquals(0, $result);
    }

    public function test_charge_ATM_with_rule_4()
    {
        $result = $this->exercise02Controller->chargeATM(false, '2021-04-28', '07:00');
        $this->assertEquals(110, $result);
    }

    public function test_is_holiday()
    {
        $result = $this->exercise02Controller->isHoliday('2021-05-01');
        $this->assertEquals(true, $result);
    }
}