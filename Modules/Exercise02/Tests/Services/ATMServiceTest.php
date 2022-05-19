<?php
declare(strict_types=1);

namespace Modules\Exercise02\Tests\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Exercise02\Models\ATM;
use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Services\ATMService;
use Tests\TestCase;

class ATMServiceTest extends TestCase
{
    protected $atmService;
    protected $cardVip;
    protected $cardNotVip;
    protected $arrayTimePeriod = [ATMService::TIME_PERIOD_1, ATMService::TIME_PERIOD_2, ATMService::TIME_PERIOD_3];

    protected function setUp(): void
    {
        parent::setUp();
        $this->atmService = new ATMService(new ATMRepository(new ATM()));
        $this->cardVip = ATM::factory()->isVip()->create()->fresh();
        $this->cardNotVip = ATM::factory()->isNotVip()->create()->fresh();
    }

    public function testCardIdNull()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->atmService->calculate(null);
    }

    public function testCardIsVip()
    {
        $response = $this->atmService->calculate($this->cardVip->card_id);
        $this->assertEquals(ATMService::NO_FEE, $response);
    }

    public function testCartFeeInWeekendAndHolidays()
    {
        $days = ['2022-05-21', '2022-05-22', '2022-01-01', '2022-05-01', '2022-04-30'];
        foreach ($days as $day) {
            foreach ($this->arrayTimePeriod as $time) {
                $this->processTestFeeInWeekendAndHolidays($time, $day);
            }
        }
    }

    public function processTestFeeInWeekendAndHolidays($timePeriod, $day)
    {
        list($minTime) = $timePeriod;
        $minTime = $minTime . '+5 minutes';
        $date = Carbon::parse($day . $minTime);
        Carbon::setTestNow($date);

        $response = $this->atmService->calculate($this->cardNotVip->card_id);
        $this->assertEquals(ATMService::NORMAL_FEE, $response);
    }

    public function testCardFeeDayOfWeekTimePeriod()
    {
        foreach ($this->arrayTimePeriod as $time) {
            $this->processTestTimePeriods($time);
        }
    }

    public function processTestTimePeriods($timePeriod)
    {
        list($minTime) = $timePeriod;
        $minTime = $minTime . '+5 minutes';
        $date = Carbon::parse('2022-05-19' . $minTime);
        Carbon::setTestNow($date);

        $response = $this->atmService->calculate($this->cardNotVip->card_id);

        $fee = ($timePeriod == ATMService::TIME_PERIOD_2) ? ATMService::NO_FEE : ATMService::NORMAL_FEE;
        $this->assertEquals($fee, $response);
    }
}
