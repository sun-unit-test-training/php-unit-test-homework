<?php

namespace Modules\Exercise06\Tests;

use Modules\Exercise06\Services\CalculateService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;
use InvalidArgumentException;

class CalculateServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalculateService();
    }

    public function test_calculate_when_invalid_argument()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculate(-1);
    }

    /**
     * @dataProvider provideData
     */
    public function test_calculate($inputData, $time)
    {
        $result = $this->service->calculate($inputData['bill'], $inputData['has_watch']);

        $this->assertEquals($result, $time);
    }

    public function provideData()
    {
        return [
            [
                [
                    'bill' => 5001,
                    'has_watch' => true,
                ], 300
            ],
            [
                [
                    'bill' => 5001,
                    'has_watch' => false,
                ], 120
            ],
            [
                [
                    'bill' => 2001,
                    'has_watch' => false,
                ], 60
            ],
            [
                [
                    'bill' => 2001,
                    'has_watch' => true,
                ], 240
            ],
            [
                [
                    'bill' => 1999,
                    'has_watch' => false,
                ], 0
            ],
        ];
    }
}
