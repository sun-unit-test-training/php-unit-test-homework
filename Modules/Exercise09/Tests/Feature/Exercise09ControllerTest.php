<?php

namespace Modules\Exercise09\Tests\Feature;

use Modules\Exercise09\Constants\Combat;
use Modules\Exercise09\Http\Controllers\Exercise09Controller;
use Modules\Exercise09\Services\CombatService;
use Tests\TestCase;

class Exercise09ControllerTest extends TestCase
{
    private $combatService;

    public function setUp(): void
    {
        parent::setUp();
        $this->combatService = $this->mock(CombatService::class);
    }

    public function test_show_index()
    {
        $url = action([Exercise09Controller::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise09::index');
    }

    private function invalidInputs($inputs)
    {
        $validInputs = [
            'dua_phep' => true,
            'quan_su' => true,
            'chia_khoa' => true,
            'kiem_anh_sang' => true,
        ];

        return array_filter(array_merge($validInputs, $inputs), function ($value) {
            return $value !== null;
        });
    }

    public function providerInvalidDuaPhep()
    {
        return [
            'Dua Phep is boolean' => ['dua_phep', 'hahaha'],
        ];
    }

    public function providerInvalidQuanSu()
    {
        return [
            'Quan Su is boolean' => ['quan_su', 'hihihi'],
        ];
    }

    public function providerInvalidChiaKhoa()
    {
        return [
            'Chia Khoa is boolean' => ['chia_khoa', 'hohoho'],
        ];
    }

    public function providerInvalidKiemAnhSang()
    {
        return [
            'Kiem Anh Sang is boolean' => ['kiem_anh_sang', 'hehehe'],
        ];
    }

    /**
     * @dataProvider providerInvalidDuaPhep
     * @dataProvider providerInvalidQuanSu
     * @dataProvider providerInvalidChiaKhoa
     * @dataProvider providerInvalidKiemAnhSang
     */
    public function test_attack_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([Exercise09Controller::class, 'attack']);

        $inputs = $this->invalidInputs([
            $inputKey => $inputValue,
        ]);

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    public function test_attack_when_input_valid()
    {
        $url = action([Exercise09Controller::class, 'attack']);

        $this->combatService->shouldReceive('calculateAttackResult')->andReturn(Combat::WON);

        $inputs = [
            'dua_phep' => true,
            'quan_su' => true,
            'chia_khoa' => true,
            'kiem_anh_sang' => true,
        ];
        $response = $this->post($url, $inputs);

        $response->assertSessionHasInput($inputs);
        $response->assertSessionHas('status', Combat::WON);
    }

    function provideEmptyDuaPhep()
    {
        return [
            'Dua Phep can be null' => ['dua_phep', null],
            'Dua Phep can be empty string' => ['dua_phep', ''],
            'Dua Phep can be string with spaces only' => ['dua_phep', '   '],
        ];
    }

    function provideEmptyQuanSu()
    {
        return [
            'Quan Su can be null' => ['quan_su', null],
            'Quan Su can be empty string' => ['quan_su', ''],
            'Quan Su can be string with spaces only' => ['quan_su', '   '],
        ];
    }

    function provideEmptyChiaKhoa()
    {
        return [
            'Chia Khoa can be null' => ['chia_khoa', null],
            'Chia Khoa can be empty string' => ['chia_khoa', ''],
            'Chia Khoa can be string with spaces only' => ['chia_khoa', '   '],
        ];
    }

    function provideEmptyKiemAnhSang()
    {
        return [
            'Kiem Anh Sang can be null' => ['kiem_anh_sang', null],
            'Kiem Anh Sang can be empty string' => ['kiem_anh_sang', ''],
            'Kiem Anh Sang can be string with spaces only' => ['kiem_anh_sang', '   '],
        ];
    }

    /**
     * @dataProvider provideEmptyDuaPhep
     * @dataProvider provideEmptyQuanSu
     * @dataProvider provideEmptyChiaKhoa
     * @dataProvider provideEmptyKiemAnhSang
     */
    public function test_attack_not_show_error_when_input_empty($inputKey, $inputValue)
    {
        $url = action([Exercise09Controller::class, 'attack']);

        $validInput = [
            'dua_phep' => true,
            'quan_su' => true,
            'chia_khoa' => true,
            'kiem_anh_sang' => true,
        ];
        $inputs = array_merge($validInput, [$inputKey => $inputValue]);

        $response = $this->post($url, $inputs);

        $response->assertSessionHasNoErrors([$inputKey]);
    }
}
