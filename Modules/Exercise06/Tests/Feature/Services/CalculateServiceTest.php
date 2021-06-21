<?php

namespace Modules\Tests\Exercise06\Tests\Feature\Http\Services;

use InvalidArgumentException;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class CalendarServiceTest extends TestCase
{
    private $calculateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateService = new CalculateService();
    }

    /**
     * @dataProvider provideData
     */
    public function testCalculate($params, $expectValue, $testCase = 'OK')
    {
        if ($testCase == 'NG') {
            $this->expectException(InvalidArgumentException::class);
        }

        $response = $this->calculateService->calculate($params['bill'], $params['hasWatch']);
        $this->assertEquals($response, $expectValue);
    }

    public function provideData()
    {
        return [
            [$this->makeData(2021, false), 60],
            [$this->makeData(5001, false), 120],
            [$this->makeData(2021, true), 240],
            [$this->makeData(5001, true), 300],
            [$this->makeData(-1, true), 0, 'NG'],
        ];
    }

    public function makeData($bill = null, $hasWatch = null)
    {
        return [
            'bill' => $bill,
            'hasWatch' => $hasWatch,
        ];
    }
}
