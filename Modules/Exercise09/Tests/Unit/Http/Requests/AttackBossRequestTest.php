<?php

namespace Modules\Exercise09\Tests\Unit\Http\Requests;

use Modules\Exercise09\Http\Requests\AttackBossRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttackBossRequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new AttackBossRequest();
    }

    public function test_rules()
    {
        $this->assertEquals([
            'dua_phep' => 'nullable|boolean',
            'quan_su' => 'nullable|boolean',
            'chia_khoa' => 'nullable|boolean',
            'kiem_anh_sang' => 'nullable|boolean',
        ], $this->request->rules());
    }
}
