<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

class Exercise08Controller extends Controller
{
    const FEMALE = 'female';

    /**
     * Calculate price
     *
     * @param $age
     * @param string $date
     * @param $gender
     * @return int|string
     */
    public function calculatePrice($age, $date = '2021-05-01', $gender)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $dayOfWeek = $date->dayOfWeek;

        if ($age < 0 || $age > 120) {
            return "Error";
        }

        if ($age < 13) {
            return 900;
        }

        if ($dayOfWeek === Carbon::TUESDAY) {
            return 1200;
        }

        if ($dayOfWeek === Carbon::FRIDAY && $gender === self::FEMALE) {
            return 1400;
        }

        if ($age > 65) {
            return 1600;
        }

        return 1800;
    }
}