<?php
declare(strict_types=1);

namespace Modules\Exercise09\Tests\Http\Controllers;

use Illuminate\View\View;
use Modules\Exercise09\Constants\Combat;
use Modules\Exercise09\Http\Controllers\Exercise09Controller;
use Modules\Exercise09\Http\Requests\AttackBossRequest;
use Modules\Exercise09\Services\CombatService;
use Tests\TestCase;

class Exercise09ControllerTest extends TestCase
{
    protected $combatService;
    protected $controller;
    protected $data = [
        'dua_phep' => '',
        'quan_su' => '',
        'chia_khoa' => '',
        'kiem_anh_sang' => ''
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->combatService = new CombatService();
        $this->controller = new Exercise09Controller($this->combatService);
    }

    public function testFunctionIndex()
    {
        $response = $this->controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise09::index', $response->getName());
    }

    public function testFunctionAttack()
    {
        $request = \Mockery::mock(AttackBossRequest::class);
        $this->data = [
            'dua_phep' => false,
            'quan_su' => true,
            'chia_khoa' => true,
            'kiem_anh_sang' => true
        ];

        $request->shouldReceive('only')->andReturn($this->data);
        $response = $this->combatService->calculateAttackResult($this->data);

        $this->assertEquals(Combat::WON, $response);
    }

    public function testValidateForm()
    {
        $this->data = [
            'dua_phep' => '10',
            'quan_su' => '11',
            'chia_khoa' => '11',
            'kiem_anh_sang' => '11'
        ];
        $url = action([Exercise09Controller::class, 'attack']);
        $response = $this->post($url, $this->data);

        $response->assertSessionHasErrors(['dua_phep', 'quan_su', 'chia_khoa', 'kiem_anh_sang']);
        $response->assertSessionMissing('status');
    }
}
