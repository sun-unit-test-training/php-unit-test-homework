<?php

namespace Modules\Exercise09\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttackBossRequest extends FormRequest
{
    public function rules()
    {
        return [
            'dua_phep' => 'nullable|boolean',
            'quan_su' => 'nullable|boolean',
            'chia_khoa' => 'nullable|boolean',
            'kiem_anh_sang' => 'nullable|boolean',
        ];
    }
}
