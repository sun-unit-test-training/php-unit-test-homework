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
     * @dataProvider input_for_calculate_attack_result
     * @param $input
     * @param $expected
     */
    public function test_calculate_attack_result($input, $expected)
    {
        $status = $this->service->calculateAttackResult($input);
        $this->assertEquals($expected, $status);
    }

    public function input_for_calculate_attack_result()
    {
        return [
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ], 3
            ],
            [
                [
                    'dua_phep' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ], 3
            ],
            [
                [
                    'quan_su' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ], 3
            ],
            [
                [
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ], 0
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'kiem_anh_sang' => true,
                ], 1
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => true,
                ], 2
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                ], 1
            ],
            [
                [
                    'dua_phep' => true,
                ], 1
            ],
            [
                [
                    'quan_su' => true,
                ], 1
            ],
            [
                [
                    'chia_khoa' => true,
                ], 0
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
