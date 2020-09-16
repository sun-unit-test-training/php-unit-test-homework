<?php

namespace Modules\Exercise04\Services;

use Illuminate\Support\Carbon;

class CalendarService
{
    const COLOR_BLACK = 'text-dark';
    const COLOR_RED = 'text-danger';
    const COLOR_BLUE = 'text-primary';

    public function getDateClass($date, $holidays)
    {
        $class = self::COLOR_BLACK;

        if ($date->dayOfWeek == Carbon::SUNDAY) {
            $class = self::COLOR_RED;
        }

        if ($date->dayOfWeek == Carbon::SATURDAY) {
            $class = self::COLOR_BLUE;
        }

        if (in_array($date->format('Y-m-d'), $holidays)) {
            $class = self::COLOR_RED;
        }

        return $class;
    }
}
