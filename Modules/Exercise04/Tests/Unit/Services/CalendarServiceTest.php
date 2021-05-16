<?php

namespace Modules\Exercise04\Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use InvalidArgumentException;
use Tests\SetupDatabaseTrait;
use Modules\Exercise04\Services\CalendarService;

class CalendarServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new CalendarService();
    }

    /**
     * @dataProvider provideDateInput
     */
    function test_get_date_class_success($inputKey, $inputDate)
    {
        $holidays = ['2020-09-26'];

        $expectedColors = [
            'sunday' => $this->service::COLOR_RED,
            'holiday' => $this->service::COLOR_RED,
            'saturday' => $this->service::COLOR_BLUE,
            'normal_day' => $this->service::COLOR_BLACK,
        ];

        $class = $this->service->getDateClass($inputDate, $holidays);

        $this->assertEquals($expectedColors[$inputKey], $class);
    }

    function provideDateInput()
    {
        return [
            ['sunday', Carbon::parse('this sunday')],
            ['holiday', Carbon::createFromFormat('Y-m-d', '2020-09-26')],
            ['saturday', Carbon::parse('this saturday')],
            ['normal_day', Carbon::parse('this monday')],
        ];
    }
}
