<?php

namespace Modules\Exercise09\Tests;

use Modules\Exercise09\Services\CombatService;
use Tests\TestCase;

class CombatServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CombatService();
    }

    /**
     * @dataProvider provideData
     * @param $input
     * @param $expected
     */
    public function test_calculate_attack_result($input, $expected)
    {
        $status = $this->service->calculateAttackResult($input);
        $this->assertEquals($expected, $status);
    }

    public function provideData()
    {
        return [
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => false,
                    'kiem_anh_sang' => false,
                ], 1
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => false,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => false,
                ], 2
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => false,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ], 3
            ],
            [
                [
                    'kiem_anh_sang' => true,
                ], 0
            ],
            [
                [], 0
            ]
        ];
    }
}
