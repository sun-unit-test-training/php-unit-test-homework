<?php

namespace Modules\Exercise04\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise04\Http\Controllers\CalendarController as Exercise;
use Modules\Exercise04\Models\Product;
use Modules\Exercise04\Services\CalendarService;
use Tests\SetupDatabaseTrait;

class CalendarControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->serviceMock = $this->mock(CalendarService::class);
    }

    function test_index()
    {
        $calendars = [];
        $j = 0;
        $holidays = ['2020-09-26'];

        $url = action([Exercise::class, 'index']);
        $dummyClass = 'class';

        for ($i = 1; $i <= 30; $i++) {
            $date = \Carbon\Carbon::createFromDate(2020, 9, $i);

            $this->serviceMock
                ->shouldReceive('getDateClass')
                ->andReturn($dummyClass);

            $calendars[$j][] = [
                'label' => $i,
                'date' => $date,
                'class' => $dummyClass,
            ];

            if ($i % 7 == 0) {
                $j++;
            }
        }

        $response = $this->get($url);

        $response->assertViewIs('exercise04::calendar');
        $response->assertViewHasAll([
            'calendars',
        ]);
    }
}
