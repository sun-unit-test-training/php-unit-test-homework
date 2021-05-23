<?php

namespace Modules\Exercise06\Tests\Unit\Services;

use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;

class CalculateServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalculateService();
    }

    public function test_calculate_throw_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $result = $this->service->calculate(-1, false);
    }

    /**
     * @param $data
     * @param $expected
     * @dataProvider provide_input_data
     * */
    public function test_calculate_return_data($data, $expected)
    {
        $time = $this->service->calculate($data['bill'], $data['has_watch']);

        $this->assertEquals($expected, $time);
    }

    public function provide_input_data()
    {
        return [
            [
                [
                    'bill' => 1000,
                    'has_watch' => false,
                ],
                'time' => 0
            ],
            [
                [
                    'bill' => 1000,
                    'has_watch' => true,
                ],
                'time' => 180
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
                    'bill' => 2000,
                    'has_watch' => false,
                ],
                'time' => 60
            ],
            [
                [
                    'bill' => 3000,
                    'has_watch' => true,
                ],
                'time' => 240
            ],
            [
                [
                    'bill' => 6000,
                    'has_watch' => true,
                ],
                'time' => 300
            ],
        ];
    }
}
