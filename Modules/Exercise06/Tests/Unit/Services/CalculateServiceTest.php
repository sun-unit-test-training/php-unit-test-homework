<?php

namespace Modules\Exercise06\Tests\Unit\Services;

use Modules\Exercise06\Services\CalculateService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;
use InvalidArgumentException;

class CalculateServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $calculateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateService = new CalculateService();
    }

    public function test_calculate_throw_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculateService->calculate(-1);
    }

    /**
     * @dataProvider provider_test_calculate
     */
    public function test_calculate($time, $inputs)
    {
        $result = $this->calculateService->calculate($inputs['bill'], $inputs['has_watch']);

        $this->assertEquals($result, $time);
    }

    function provider_test_calculate()
    {
        return [
            'CASE_1 and has watch' => [
                240,
                [
                    'bill' => 2000,
                    'has_watch' => true,
                ]
            ],
            'CASE_1 and no watch' => [
                60,
                [
                    'bill' => 3000,
                    'has_watch' => false,
                ]
            ],
            'CASE_2 and has watch' => [
                300,
                [
                    'bill' => 5000,
                    'has_watch' => true,
                ]
            ],
            'CASE_2 and no watch' => [
                120,
                [
                    'bill' => 6000,
                    'has_watch' => false,
                ]
            ],
            'FREE_TIME_FOR_MOVIE and has watch' => [
                180,
                [
                    'bill' => 1000,
                    'has_watch' => true,
                ]
            ],
            'FREE_TIME_FOR_MOVIE and no watch' => [
                0,
                [
                    'bill' => 1000,
                    'has_watch' => false,
                ]
            ],
        ];
    }
}
