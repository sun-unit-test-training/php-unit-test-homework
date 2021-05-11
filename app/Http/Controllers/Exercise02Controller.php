<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

class Exercise02Controller extends Controller
{
    const NORMAL_FREE = 110;
    const FREE = 0;
    const TIME_PERIOD = ['08:45', '17:59'];
    //example default holiday
    const HOLIDAYS = ['01-01', '10-03', '02-09'];

    /**
     * charge ATM
     *
     * @param bool $isVip
     * @param string $date
     * @param string $time
     * @return int
     */
    public function chargeATM($isVip = true, $date = '2021-05-01', $time = '14:25'): int
    {
        //rule1
        if ($isVip) {
            return self::FREE;
        }
        //rule2
        if($this->isWeekend($date) || $this->isHoliday($date)) {
            return self::NORMAL_FREE;
        }
        //rule3
        if ($this->isTimeDiscount($date, $time)) {
            return self::FREE;
        }
        //rule4
        return self::NORMAL_FREE;
    }

    /**
     * Check is weekend
     *
     * @param $date
     * @return bool
     */
    public function isWeekend($date): bool
    {
        if (Carbon::createFromFormat('Y-m-d', $date)->isWeekend()) {
            return true;
        }

        return false;
    }

    /**
     * Check is holiday
     *
     * @param $date
     * @return bool
     */
    public function isHoliday($date): bool
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        if (in_array($date->format('d-m'), self::HOLIDAYS)) {
            return true;
        }

        return false;
    }

    /**
     * Check is time discount
     *
     * @param $date
     * @param $time
     * @return bool
     */
    public function isTimeDiscount($date, $time): bool
    {
        $date = Carbon::createFromFormat('Y-m-d H:i', $date . " " . $time);
        $time = $date->format('H:i');
        list($minTime, $maxTime) = self::TIME_PERIOD;

        if ($time >= $minTime && $time <= $maxTime) {
            return true;
        }

        return false;
    }
}