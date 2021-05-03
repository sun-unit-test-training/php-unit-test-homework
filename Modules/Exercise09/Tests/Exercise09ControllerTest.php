<?php

namespace Modules\Exercise09\Tests;

use Modules\Exercise09\Http\Controllers\Exercise09Controller;
use Modules\Exercise09\Services\CombatService;
use Tests\TestCase;
use Mockery;

class Exercise09ControllerTest extends TestCase
{
    public function test__construct()
    {
        $service = Mockery::mock(CombatService::class);
        $controller = new Exercise09Controller($service);
        $serviceRef = $this->getHiddenProperty($controller, 'attackBossService');
        $this->assertSame($service, $serviceRef->getValue($controller));
    }

    public function test_index()
    {
        $response = $this->get(action([Exercise09Controller::class, 'index']));
        $response->assertStatus(200);
        $response->assertViewIs('exercise09::index');
    }

    /**
     * @dataProvider input_for_attack
     * @param $input
     */
    public function test_attack_success($input)
    {
        $response = $this->post(action([Exercise09Controller::class, 'attack']), $input);

        $response->assertStatus(302);
        $this->assertTrue($response->isRedirection());
        $response->assertSessionHas('status');
        $response->assertSessionHas('_old_input');
    }

    public function input_for_attack()
    {
        return [
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => true,
                    'kiem_anh_sang' => true,
                ]
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                    'chia_khoa' => true,
                ]
            ],
            [
                [
                    'dua_phep' => true,
                    'quan_su' => true,
                ]
            ],
            [
                [
                    'dua_phep' => true,
                ]
            ],
            [
                []
            ],
            // lazy
        ];
    }
}
