<?php

namespace Modules\Exercise06\Tests\Unit\Services;

use InvalidArgumentException;
use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class CalculateServiceTest extends TestCase
{
    protected $calculateService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calculateService = new CalculateService();
    }

    public function test_exception_calculate()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculateService->calculate(0);
    }

    /**
     * @param $data
     * @param $expectedValue
     * @dataProvider provideData
     * */
    public function test_calculate($data, $expectedValue)
    {
        $time = $this->calculateService->calculate($data['bill'], $data['has_watch']);
        $this->assertEquals($expectedValue, $time);
    }

    public function provideData()
    {
        return [
            [
                [
                    'bill' => 2000,
                    'has_watch' => false,
                ],
                'time' => 60
            ],
            [
                [
                    'bill' => 2000,
                    'has_watch' => true,
                ],
                'time' => 240
            ],
            [
                [
                    'bill' => 5000,
                    'has_watch' => false,
                ],
                'time' => 120
            ],
            [
                [
                    'bill' => 5000,
                    'has_watch' => true,
                ],
                'time' => 300
            ],
        ];
    }
}
