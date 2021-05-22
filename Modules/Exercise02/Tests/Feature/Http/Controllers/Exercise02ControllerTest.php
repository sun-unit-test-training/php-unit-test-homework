<?php

namespace Modules\Exercise02\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise02\Http\Controllers\Exercise02Controller as Exercise;
use Modules\Exercise02\Models\ATM;
use Modules\Exercise02\Services\ATMService;
use Tests\SetupDatabaseTrait;

class Exercise02Test extends TestCase
{
    use SetupDatabaseTrait;

    protected $atmServiceMock;
    protected $controllerMethod;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->atmServiceMock = $this->mock(ATMService::class);
        $this->controllerMethod = 'takeATMFee';
    }

    function test_index()
    {
        $url = action([Exercise::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise02::index');
        $response->assertViewHasAll([
            'normalFee',
            'noFee',
            'timePeriod1',
            'timePeriod2',
            'timePeriod3',
        ]);
    }

    /**
     * @dataProvider provideWrongCardId
     */
    function test_it_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([Exercise::class, $this->controllerMethod]);
        $inputs = [$inputKey => $inputValue];

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    function provideWrongCardId()
    {
        return [
            'Card is missing' => [null, null],
            'Card is required' => ['card_id', null],
            'Card must exist' => ['card_id', 'this-card-not-exist'],
        ];
    }

    function test_it_take_atm_fee_when_input_valid_card_id()
    {
        $dummyCardData = ['card_id' => 'new-card_id'];
        $dummyFee = ATMService::NORMAL_FEE;

        ATM::factory()->create($dummyCardData);
        $this->atmServiceMock
            ->shouldReceive('calculate')
            ->andReturn($dummyFee);

        $url = action([Exercise::class, $this->controllerMethod]);

        $response = $this->post($url, $dummyCardData);

        $response->assertSessionDoesntHaveErrors(['card_id']);
        $response->assertSessionHasInput(['card_id']);
        $response->assertSessionHas('calculate', function ($calculate) use ($dummyFee) {
            return $calculate['fee'] == $dummyFee;
        });
    }

}
