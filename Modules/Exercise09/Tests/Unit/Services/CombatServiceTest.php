<?php

namespace Modules\Exercise09\Tests\Unit\Services;

use Modules\Exercise09\Services\CombatService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CombatServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new CombatService();
    }

    /**
     * @param $inputs
     * @param $expected
     * @dataProvider provide_input_data
     */
    public function test_calculate_attack_result($inputs, $expected)
    {
        $status = $this->service->calculateAttackResult($inputs);
        $this->assertEquals($expected, $status);
    }

    public function provide_input_data()
    {
        return [
            [
                [],
                0
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => false,
                ],
                1
            ],
            [
                [
                    'dua_phep' => false,
                    'quan_su' => true,
                ],
                1
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => false,
                    'chia_khoa' => true,
                ],
                2
            ],
            [
                [
                    'dua_phep' => false,
                    'quan_su' => true,
                    'chia_khoa' => true,
                ],
                2
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ], 3
            ],
        ];
    }
}
