<?php

namespace Modules\Exercise06\Tests\Unit\Services;

use Modules\Exercise06\Services\CalculateService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;
use InvalidArgumentException;

class CalculateServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalculateService();
    }

    public function test_it_calculate_when_invalid_argument()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculate(0);
    }

    /**
     * @dataProvider provideData
     */
    public function test_it_calculate($time, $data)
    {
        $result = 0;
        if (isset($data['has_watch'])) {
            $result = $this->service->calculate($data['bill'], $data['has_watch']);
        } else {
            $result = $this->service->calculate($data['bill']);
        }

        $this->assertEquals($result, $time);
    }

    function provideData()
    {
        return [
            'Bill >= 5000 and has watch' => [
                300,
                [
                    'bill' => 5000,
                    'has_watch' => true,
                ]
            ],
            'Bill >= 5000 and no watch' => [
                120,
                [
                    'bill' => 5000,
                    'has_watch' => false,
                ]
            ],
            'Bill >= 2000 and has watch' => [
                240,
                [
                    'bill' => 2000,
                    'has_watch' => true,
                ]
            ],
            'Bill >= 2000 and no watch' => [
                60,
                [
                    'bill' => 2000,
                    'has_watch' => false,
                ]
            ],
            'Bill < 2000 and has watch' => [
                180,
                [
                    'bill' => 1999,
                    'has_watch' => true,
                ]
            ],
            'Bill < 2000 and no watch' => [
                0,
                [
                    'bill' => 1999,
                    'has_watch' => false,
                ]
            ],
            'no pass argument has_watch' => [
                60,
                [
                    'bill' => 2000,
                ]
            ],
        ];
    }
}
