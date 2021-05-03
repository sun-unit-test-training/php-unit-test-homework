<?php

namespace Modules\Exercise09\Tests;

use Modules\Exercise09\Constants\Combat;
use Tests\TestCase;

class CombatConstantTest extends TestCase
{
    public function test_const()
    {
        $this->assertEquals(0, Combat::ROOM_NOT_FOUND);
        $this->assertEquals(1, Combat::ROOM_FINDABLE);
        $this->assertEquals(2, Combat::ROOM_ACCESSIBLE);
        $this->assertEquals(3, Combat::WON);
    }
}
