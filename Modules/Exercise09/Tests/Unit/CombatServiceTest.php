<?php

namespace Modules\Exercise09\Tests\Unit;

use Modules\Exercise09\Constants\Combat;
use Tests\TestCase;
use Modules\Exercise09\Services\CombatService;

class CombatServiceTest extends TestCase
{
    private $combatService;

    public function setUp(): void
    {
        parent::setUp();
        $this->combatService = new CombatService();
    }

    public function providerValidData()
    {
        return [
            [
                [
                    'dua_phep' => null,
                    'quan_su' => null,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ],
                Combat::ROOM_NOT_FOUND
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => null,
                    'chia_khoa' => null,
                    'kiem_anh_sang' => true,
                ],
                Combat::ROOM_FINDABLE
            ],
            [
                [
                    'dua_phep' => null,
                    'quan_su' => true,
                    'chia_khoa' => null,
                    'kiem_anh_sang' => true,
                ],
                Combat::ROOM_FINDABLE
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => null,
                    'kiem_anh_sang' => true,
                ],
                Combat::ROOM_FINDABLE
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => null,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => null,
                ],
                Combat::ROOM_ACCESSIBLE
            ],
            [
                [
                    'dua_phep' => null,
                    'quan_su' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => null,
                ],
                Combat::ROOM_ACCESSIBLE
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => null,
                ],
                Combat::ROOM_ACCESSIBLE
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => null,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ],
                Combat::WON
            ],
            [
                [
                    'dua_phep' => null,
                    'quan_su' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ],
                Combat::WON
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ],
                Combat::WON
            ],
        ];
    }

    /**
     * @dataProvider providerValidData
     */
    public function test_calculateAttackResult($inputs, $expectedPrice)
    {
        $result = $this->combatService->calculateAttackResult($inputs);

        $this->assertEquals($expectedPrice, $result);
    }
}
