<?php

namespace Modules\Exercise09\Services;

use Illuminate\Support\Arr;
use Modules\Exercise09\Constants\Combat;

class CombatService
{
    /**
     * Calculate result - win or lose - when attack boss
     * @param array $data
     * @return int
     */
    public function calculateAttackResult(array $data) : int
    {
        $hasDuaPhep = Arr::get($data, 'dua_phep', 0);
        $hasQuanSu = Arr::get($data, 'quan_su', 0);
        $hasChiaKhoa = Arr::get($data, 'chia_khoa', 0);
        $hasKiemAnhSang = Arr::get($data, 'kiem_anh_sang', 0);

        $status = Combat::ROOM_NOT_FOUND;
        if ($hasDuaPhep || $hasQuanSu) {
            $status = Combat::ROOM_FINDABLE;
        }

        if ($status === Combat::ROOM_FINDABLE && $hasChiaKhoa) {
            $status = Combat::ROOM_ACCESSIBLE;
        }

        if ($status === Combat::ROOM_ACCESSIBLE && $hasKiemAnhSang) {
            $status = Combat::WON;
        }

        return $status;
    }
}