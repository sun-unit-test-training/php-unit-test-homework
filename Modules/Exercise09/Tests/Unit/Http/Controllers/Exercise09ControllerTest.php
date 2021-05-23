<?php

namespace Modules\Exercise09\Tests\Unit\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Exercise09\Http\Controllers\Exercise09Controller;
use Modules\Exercise09\Http\Requests\AttackBossRequest;
use Modules\Exercise09\Services\CombatService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Exercise09ControllerTest extends TestCase
{
    protected $controller;
    protected $serviceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = $this->mock(CombatService::class);
        $this->controller = new Exercise09Controller($this->serviceMock);
    }

    public function test_index_return_view()
    {
        $response = $this->controller->index();

        $this->assertEquals('exercise09::index', $response->getName());
    }

    public function test_attack()
    {
        $inputs = [
            'dua_phep' => true,
            'quan_su' => true,
            'chia_khoa' => true,
            'kiem_anh_sang' => true,
        ];

        $request = AttackBossRequest::create('', 'POST', $inputs);

        $this->serviceMock->shouldReceive('calculateAttackResult')
            ->with($inputs)
            ->once()
            ->andReturn(3);

        $response = $this->controller->attack($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(3, $response->getSession()->get('status'));
    }
}
