<?php
namespace App\Modules\Exercise04\Tests\Services;

use Mockery;
use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;
use Illuminate\Support\Carbon;

class CalendarServiceTest extends TestCase
{

    /**
     * @dataProvider providerTestGetDateClass
     */
    public function testGetDateClass($input, $expect)
    {
        $holidays = ['2021-04-25'];
        $service = new CalendarService;
        $response = $service->getDateClass($input, $holidays);

        $this->assertEquals($expect, $response);
    }

    public function providerTestGetDateClass()
    {
        return [
            [
                new Carbon('2021-04-21'),
                CalendarService::COLOR_BLACK,
            ],
            [
                new Carbon('2021-04-25'),
                CalendarService::COLOR_RED,
            ],
            [
                new Carbon('2021-04-24'),
                CalendarService::COLOR_BLUE,
            ],
            [
                new Carbon('2021-04-25'),
                CalendarService::COLOR_RED,
            ],
        ];
    }
}
