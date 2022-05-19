<?php
declare(strict_types=1);

namespace Modules\Exercise09\Tests\Services;

use Modules\Exercise09\Constants\Combat;
use Modules\Exercise09\Services\CombatService;
use Tests\TestCase;

class CombatServiceTest extends TestCase
{
    protected $combatService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->combatService = new CombatService();
    }

    public function testNotFoundData()
    {
        $data = $this->getSampleData();
        $response = $this->combatService->calculateAttackResult($data);

        $this->assertEquals(Combat::ROOM_NOT_FOUND, $response);
    }

    public function testChooseDuaPhepQuanSu()
    {
        $data = $this->getSampleData();
        $data['dua_phep'] = true;

        if ($data['dua_phep'] && !$data['quan_su']) {
            $response = $this->combatService->calculateAttackResult($data);
            $data['dua_phep'] = false;
            $data['quan_su'] = true;

            $this->assertEquals(Combat::ROOM_FINDABLE, $response);
        }

        if ($data['quan_su'] && !$data['dua_phep']) {
            $response = $this->combatService->calculateAttackResult($data);
            $data['dua_phep'] = true;
            $this->assertEquals(Combat::ROOM_FINDABLE, $response);
        }

        if ($data['quan_su'] && $data['dua_phep']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::ROOM_FINDABLE, $response);
        }
    }

    public function testChooseChiaKhoa()
    {
        $data = $this->getSampleData();
        $data['chia_khoa'] = true;

        $response = $this->combatService->calculateAttackResult($data);
        $this->assertEquals(Combat::ROOM_NOT_FOUND, $response);

        $data['dua_phep'] = true;
        if ($data['dua_phep'] && $data['chia_khoa']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::ROOM_ACCESSIBLE, $response);
            $data['dua_phep'] = false;
            $data['quan_su'] = true;
        }

        if ($data['quan_su'] && $data['chia_khoa']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::ROOM_ACCESSIBLE, $response);
            $data['dua_phep'] = true;
        }

        if ($data['dua_phep'] && $data['quan_su'] && $data['chia_khoa']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::ROOM_ACCESSIBLE, $response);
        }
    }

    public function testChooseKiemAnhSang()
    {
        $data = $this->getSampleData();
        $data['kiem_anh_sang'] = true;

        $response = $this->combatService->calculateAttackResult($data);
        $this->assertEquals(Combat::ROOM_NOT_FOUND, $response);

        $data['chia_khoa'] = true;
        if ($data['chia_khoa'] && $data['kiem_anh_sang']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::ROOM_NOT_FOUND, $response);
            $data['chia_khoa'] = false;
            $data['dua_phep'] = true;
        }

        if ($data['dua_phep'] && $data['kiem_anh_sang']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::ROOM_FINDABLE, $response);
            $data['dua_phep'] = false;
            $data['quan_su'] = true;
        }

        if ($data['quan_su'] && $data['kiem_anh_sang']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::ROOM_FINDABLE, $response);
            $data['dua_phep'] = true;
        }

        if ($data['dua_phep'] && $data['quan_su'] && $data['kiem_anh_sang']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::ROOM_FINDABLE, $response);
            $data['quan_su'] = false;
            $data['chia_khoa'] = true;
        }

        if ($data['dua_phep'] && $data['chia_khoa'] && $data['kiem_anh_sang']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::WON, $response);
            $data['dua_phep'] = false;
            $data['quan_su'] = true;
        }

        if ($data['quan_su'] && $data['chia_khoa'] && $data['kiem_anh_sang']) {
            $response = $this->combatService->calculateAttackResult($data);
            $this->assertEquals(Combat::WON, $response);
            $data['dua_phep'] = true;
        }

        $response = $this->combatService->calculateAttackResult($data);
        $this->assertEquals(Combat::WON, $response);
    }

    public function getSampleData()
    {
        return [
            'dua_phep' => '',
            'quan_su' => '',
            'chia_khoa' => '',
            'kiem_anh_sang' => ''
        ];
    }
}
