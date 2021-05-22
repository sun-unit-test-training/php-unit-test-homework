<?php

namespace Modules\Exercise06\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise09\Http\Controllers\Exercise09Controller;
use Modules\Exercise09\Services\CombatService;
use Tests\SetupDatabaseTrait;

class Exercise09ControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CombatService();
    }

    function test_index_return_view()
    {
        $url = action([Exercise09Controller::class, 'index']);
        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertViewIs('exercise09::index');
    }

    public function test_attack_success()
    {
        $input = [
            'dua_phep' => true,
            'quan_su' => true,
            'chia_khoa' => true,
            'kiem_anh_sang' => true,
        ];

        $response = $this->post(action([Exercise09Controller::class, 'attack']), $input);

        $this->assertTrue($response->isRedirection());
        $response->assertSessionHas('status');
    }
}
