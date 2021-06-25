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

    public function testCalculateInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculate(0);
    }

    /**
     * @dataProvider inputData
     */
    public function testCalculateSuccess($time, $data)
    {
        $result = $this->service->calculate($data['bill'], $data['has_watch']);

        $this->assertEquals($result, $time);
    }

    function inputData()
    {
        return [
            [
                300,
                [
                    'bill' => 5000,
                    'has_watch' => true,
                ]
            ],
            [
                120,
                [
                    'bill' => 5000,
                    'has_watch' => false,
                ]
            ],
            [
                240,
                [
                    'bill' => 2000,
                    'has_watch' => true,
                ]
            ],
            [
                60,
                [
                    'bill' => 2000,
                    'has_watch' => false,
                ]
            ],
            [
                180,
                [
                    'bill' => 1999,
                    'has_watch' => true,
                ]
            ],
            [
                0,
                [
                    'bill' => 1999,
                    'has_watch' => false,
                ]
            ],
        ];
    }
}
