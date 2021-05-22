<?php

namespace Modules\Exercise06\Tests\Unit\Services;

use Tests\TestCase;
use InvalidArgumentException;
use Modules\Exercise06\Services\CalculateService;

class CalculateServiceTest extends TestCase
{
    protected $service;
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new CalculateService();
    }

    /**
     * @dataProvider provideBillInvalid
     */
    function test_it_throw_exception_when_bill_invalid($inputValue)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculate($inputValue);
    }

    function provideBillInvalid()
    {
        return [
            'invalid_bill_is_zero' => [0],
            'invalid_bill_is_less_than_zero' => [-1],
        ];
    }

    function test_calculate_with_small_bill_and_no_watch()
    {
        $expectedTime = 0;

        list($minBill1, $freeTime1) = $this->service::CASE_1;
        $smallBill = $minBill1 - 1;

        $time = $this->service->calculate($smallBill);

        $this->assertEquals($expectedTime, $time);
    }

    function test_calculate_with_small_bill_and_watch()
    {
        $expectedTime = $this->service::FREE_TIME_FOR_MOVIE;

        list($minBill1, $freeTime1) = $this->service::CASE_1;
        $smallBill = $minBill1 - 1;
        $watchedMovie = true;

        $time = $this->service->calculate($smallBill, $watchedMovie);

        $this->assertEquals($expectedTime, $time);
    }

    /**
     * @dataProvider provideWatchMovie
     */
    function test_calculate_with_medium_bill($watchedMovie)
    {
        list($minBill1, $freeTime1) = $this->service::CASE_1;

        $dummyBills = [
            $minBill1,
            $minBill1 + 1,
        ];

        foreach ($dummyBills as $mediumBill) {
            $expectedTime = $freeTime1;

            if ($watchedMovie) {
                $expectedTime += $this->service::FREE_TIME_FOR_MOVIE;
            }

            $time = $this->service->calculate($mediumBill, $watchedMovie);

            $this->assertEquals($expectedTime, $time);
        }
    }

    /**
     * @dataProvider provideWatchMovie
     */
    function test_calculate_with_big_bill($watchedMovie)
    {
        list($minBill2, $freeTime2) = $this->service::CASE_2;

        $dummyBills = [
            $minBill2,
            $minBill2 + 1,
        ];

        foreach ($dummyBills as $mediumBill) {
            $expectedTime = $freeTime2;

            if ($watchedMovie) {
                $expectedTime += $this->service::FREE_TIME_FOR_MOVIE;
            }

            $time = $this->service->calculate($mediumBill, $watchedMovie);

            $this->assertEquals($expectedTime, $time);
        }
    }

    function provideWatchMovie()
    {
        return [
            'dont_watch_movie' => [false],
            'watched_movie' => [true],
        ];
    }
}
