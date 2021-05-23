<?php

namespace Modules\Exercise06\Tests\Feature;

use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Tests\TestCase;
use Modules\Exercise06\Services\CalculateService;

class Exercise06ControllerTest extends TestCase
{
    private $calculateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateService = $this->mock(CalculateService::class);
    }

    public function test_show_index()
    {
        $url = action([Exercise06Controller::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise06::index');
        $response->assertViewHasAll([
            'case1',
            'case2',
            'freeTimeForMovie',
        ]);
        $response->assertViewHas('case1', CalculateService::CASE_1);
        $response->assertViewHas('case2', CalculateService::CASE_2);
        $response->assertViewHas('freeTimeForMovie', CalculateService::FREE_TIME_FOR_MOVIE);
        $response->assertSessionMissing('result');
    }


    private function invalidInputs($inputs)
    {
        $validInputs = [
            'bill' => 100,
            'has_watch' => null,
        ];

        return array_filter(array_merge($validInputs, $inputs), function ($value) {
            return $value !== null;
        });
    }

    public function providerInvalidBill()
    {
        return [
            'Bill is required' => ['bill', null],
            'Bill should be integer' => ['bill', 100.4],
            'Bill should be min 0' => ['bill', -1],
        ];
    }

    public function providerInvalidHaswatch()
    {
        return [
            'has_watch should be boolean' => ['has_watch', '100'],
        ];
    }

    /**
     * @dataProvider providerInvalidBill
     * @dataProvider providerInvalidHaswatch
     */
    public function test_calculate_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([Exercise06Controller::class, 'calculate']);

        $inputs = $this->invalidInputs([
            $inputKey => $inputValue,
        ]);

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    public function test_calculate_when_input_valid()
    {
        $url = action([Exercise06Controller::class, 'calculate']);

        $this->calculateService->shouldReceive('calculate')->andReturn(100);

        $inputs = ['bill'  => 100];
        $response = $this->post($url, $inputs);

        $response->assertSessionHasInput($inputs);
        $response->assertSessionHas('result', ['time' => 100]);
    }

    public function provideEmptyHasWatch()
    {
        return [
            'Has Watch can be null' => [null],
            'Has Watch can be empty string' => [''],
            'Has Watch can be string with spaces only' => ['   '],
        ];
    }

    /**
     * @dataProvider provideEmptyHasWatch
     */
    function test_it_should_not_error_when_input_empty_has_watch($hasWatch)
    {
        $url = action([Exercise06Controller::class, 'calculate']);
        $this->calculateService
            ->shouldReceive('calculate')
            ->andReturn(100);

        $response = $this->post($url, [
            'bill' => 100,
            'has_watch' => $hasWatch,
        ]);

        $response->assertSessionDoesntHaveErrors(['has_watch']);
    }
}
