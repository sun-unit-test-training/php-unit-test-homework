<?php

namespace Modules\Exercise02\Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use InvalidArgumentException;
use Tests\SetupDatabaseTrait;
use Modules\Exercise02\Models\ATM;
use Modules\Exercise02\Services\ATMService;
use Modules\Exercise02\Repositories\ATMRepository;

class ATMServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $model;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new ATM;
        $atmRepository = new ATMRepository($this->model);

        $this->service = new ATMService($atmRepository);
    }

    function test_it_throw_exception_when_card_not_exists()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculate('new-card_id');
    }

    function test_it_return_fee_when_card_is_vip()
    {
        $dummyCardData = ['card_id' => 'new-card_id', 'is_vip' => true];
        $expectedFee = $this->service::NO_FEE;

        $card = $this->model->factory()->create($dummyCardData);
        $fee = $this->service->calculate($card->card_id);

        $this->assertEquals($expectedFee, $fee);
    }

    /**
     * @dataProvider provideWeekendTime
     */
    function test_it_return_fee_in_weekend_time($currentTime)
    {
        Carbon::setTestNow($currentTime);

        $dummyCardData = ['card_id' => 'new-card_id', 'is_vip' => false];
        $expectedFee = $this->service::NORMAL_FEE;

        $card = $this->model->factory()->create($dummyCardData);
        $fee = $this->service->calculate($card->card_id);

        $this->assertEquals($expectedFee, $fee);
    }

    function provideWeekendTime()
    {
        return [
            'saturday' => [Carbon::parse('this saturday')],
            'sunday' => [Carbon::parse('this sunday')],
        ];
    }

    function test_it_return_fee_in_holiday_time()
    {
        $expectedFee = $this->service::NORMAL_FEE;

        $dates = array_merge($this->getHoliday(), $this->getNormalTime());

        foreach ($dates as $key => $day) {
            Carbon::setTestNow($day);

            $dummyCardData = ['card_id' => 'new-card_id_' . $key, 'is_vip' => false];

            $card = $this->model->factory()->create($dummyCardData);
            $fee = $this->service->calculate($card->card_id);

            $this->assertEquals($expectedFee, $fee);
        }
    }

    function getHoliday()
    {
        $results = [];
        $holidays = $this->service::HOLIDAYS;

        foreach ($holidays as $day) {
            $results[] = Carbon::createFromFormat('d-m', $day);
        }

        return $results;
    }

    function getNormalTime()
    {
        list($minTimePeriod2, $maxTimePeriod2) = $this->service::TIME_PERIOD_2;

        $normalDay = Carbon::parse('this monday')->format('Y-m-d');

        $minNormalTime = Carbon::createFromFormat('Y-m-d H:i', $normalDay . ' ' . $minTimePeriod2)->subMinutes(1);
        $maxNormalTime = Carbon::createFromFormat('Y-m-d H:i', $normalDay . ' ' . $maxTimePeriod2)->addMinutes(1);

        return [
            'before_special_time' => $minNormalTime,
            'after_special_time' => $maxNormalTime,
        ];
    }

    function test_it_return_fee_in_special_time()
    {
        $expectedFee = $this->service::NO_FEE;

        foreach ($this->getSpecialTime() as $key => $day) {
            Carbon::setTestNow($day);

            $dummyCardData = ['card_id' => 'new-card_id_' . $key, 'is_vip' => false];

            $card = $this->model->factory()->create($dummyCardData);
            $fee = $this->service->calculate($card->card_id);

            $this->assertEquals($expectedFee, $fee);
        }
    }

    function getSpecialTime()
    {
        $results = [];
        list($minTimePeriod2, $maxTimePeriod2) = $this->service::TIME_PERIOD_2;

        $normalDay = Carbon::parse('this monday')->format('Y-m-d');

        $minSpecialTime = Carbon::createFromFormat('Y-m-d H:i', $normalDay . ' ' . $minTimePeriod2);
        $maxSpecialTime = Carbon::createFromFormat('Y-m-d H:i', $normalDay . ' ' . $maxTimePeriod2);

        $results = [
            'min_special_time' => $minSpecialTime,
            'max_special_time' => $maxSpecialTime,
        ];

        $minSpecialTimeTmp = Carbon::createFromFormat('Y-m-d H:i', $normalDay . ' ' . $minTimePeriod2);

        $diffHours = $minSpecialTimeTmp->diffInHours($maxSpecialTime);
        $diffMinutes = $minSpecialTimeTmp->diffInMinutes($maxSpecialTime);

        if ($diffHours > 1) {
            $results['between_special_time'] = $minSpecialTimeTmp->addHours($diffHours/2);
        } elseif ($diffHours == 1) {
            $results['between_special_time'] = $minSpecialTimeTmp->addMinutes(30);
        } elseif ($diffMinutes > 1) {
            $results['between_special_time'] = $minSpecialTimeTmp->addMinutes($diffMinutes/2);
        }

        return $results;
    }
}
