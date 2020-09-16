<?php

namespace Modules\Exercise04\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Modules\Exercise04\Services\CalendarService;

class CalendarController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index()
    {
        $calendars = [];
        $j = 0;
        $holidays = ['2020-09-26'];
        for ($i = 1; $i <= 30; $i++) {
            $date = Carbon::createFromDate(2020, 9, $i);
            $calendars[$j][] = [
                'label' => $i,
                'date' => $date,
                'class' => $this->calendarService->getDateClass($date, $holidays),
            ];

            if ($i % 7 == 0) {
                $j++;
            }
        }

        return view('exercise04::calendar', [
            'calendars' => $calendars,
        ]);
    }
}
