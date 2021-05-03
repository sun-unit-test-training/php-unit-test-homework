<?php

namespace Modules\Exercise09\Tests;

use Modules\Exercise09\Http\Requests\AttackBossRequest;
use Tests\TestCase;

class AttackBossRequestTest extends TestCase
{
    public function test_rules()
    {
        $request = new AttackBossRequest();
        $this->assertEquals([
            'dua_phep' => 'nullable|boolean',
            'quan_su' => 'nullable|boolean',
            'chia_khoa' => 'nullable|boolean',
            'kiem_anh_sang' => 'nullable|boolean',
        ], $request->rules());
    }
}
