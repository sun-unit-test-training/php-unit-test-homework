<?php

namespace Modules\Exercise06\Services;

use Carbon\Carbon;
use InvalidArgumentException;

class CaculateService
{
    const CASE_1 = [2000, 60];
    const CASE_2 = [5000, 120];
    const FREE_TIME_FOR_MOVIE = 180;

    /**
     * Calcuate price
     *
     * @param int $bill
     * @param boolean $watchedMovie
     *
     * @return int $time
     */
    public function calculate($bill, $hasWatch = false)
    {
        $time = 0;

        if ($bill <= 0) {
            throw new InvalidArgumentException('Bill must be greater than 0');
        }

        list($minBill1, $freeTime1) = self::CASE_1;
        list($minBill2, $freeTime2) = self::CASE_2;
        if ($bill >= $minBill2) {
            $time = $freeTime2;
        } else if ($bill >= $minBill1) {
            $time = $freeTime1;
        }

        if ($hasWatch) {
            $time += self::FREE_TIME_FOR_MOVIE;
        }

        return $time;
    }
}
