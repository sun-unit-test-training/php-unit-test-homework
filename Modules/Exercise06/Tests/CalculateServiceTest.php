<?php

namespace Modules\Exercise05\Tests;

use InvalidArgumentException;
use Modules\Exercise06\Services\CalculateService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class CalculateServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new CalculateService();
    }

    public function testItThrowException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculate(-1);
    }

    /**
     * @dataProvider caseForTest
     * @param $bill
     * @param $hasWatch
     * @param $result
     */
    public function testHandleDiscount($bill, $hasWatch, $result)
    {
        $time = $this->service->calculate($bill, $hasWatch);

        $this->assertEquals($result, $time);
    }

    public function caseForTest()
    {
        return [
            [
                6000,
                true,
                300
            ],
            [
                3000,
                true,
                240
            ],
        ];
    }
}