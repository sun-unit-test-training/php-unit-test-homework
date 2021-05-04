<?php

namespace Modules\Exercise02\Tests\Unit\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Exercise02\Models\ATM;
use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Services\ATMService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class ATMServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $atmService;
    protected $vipCard;
    protected $notVipCard;

    public function setUp(): void
    {
        parent::setUp();
        $atmRepository = new ATMRepository(new ATM());
        $this->atmService = new ATMService($atmRepository);
        $this->vipCard = ATM::factory()->isVip()->create()->fresh();
        $this->notVipCard = ATM::factory()->isNotVip()->create()->fresh();
    }

    public function test_it_throw_exception_when_card_is_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->atmService->calculate(-1);
    }

    /*
     * ==================== VIP TEST ====================
     */
    public function test_it_calculate_fee_when_card_is_vip()
    {
        $fee = $this->atmService->calculate($this->vipCard->card_id);

        $this->assertEquals(ATMService::NO_FEE, $fee);
    }

    public function test_it_calculate_fee_when_card_is_vip_in_weekend()
    {
        $date = Carbon::parse('2021-09-26');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->vipCard->card_id);

        $this->assertEquals(ATMService::NO_FEE, $fee);
    }

    public function test_it_calculate_fee_when_card_is_vip_in_holiday()
    {
        $date = Carbon::parse('2021-01-01');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->vipCard->card_id);

        $this->assertEquals(ATMService::NO_FEE, $fee);
    }

    public function test_it_calculate_fee_when_card_is_vip_in_normal_date_special_time_1()
    {
        list($minTime) = ATMService::TIME_PERIOD_1;
        $date = Carbon::parse('2021-09-22 ' . $minTime . ' +30 minutes');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->vipCard->card_id);

        $this->assertEquals(ATMService::NO_FEE, $fee);
    }

    public function test_it_calculate_fee_when_card_is_vip_in_normal_date_special_time_2()
    {
        list($minTime) = ATMService::TIME_PERIOD_2;
        $date = Carbon::parse('2021-09-22 ' . $minTime . ' +30 minutes');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->vipCard->card_id);

        $this->assertEquals(ATMService::NO_FEE, $fee);
    }

    public function test_it_calculate_fee_when_card_is_vip_in_normal_date_special_time_3()
    {
        list($minTime) = ATMService::TIME_PERIOD_3;
        $date = Carbon::parse('2021-09-22 ' . $minTime . ' +30 minutes');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->vipCard->card_id);

        $this->assertEquals(ATMService::NO_FEE, $fee);
    }

    /*
     * ==================== NORMAL TEST ====================
     */
    public function test_it_calculate_fee_when_normal_card_in_weekend()
    {
        $date = Carbon::parse('2021-09-26');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->notVipCard->card_id);

        $this->assertEquals(ATMService::NORMAL_FEE, $fee);
    }

    public function test_it_calculate_fee_when_normal_card_in_holiday()
    {
        $date = Carbon::parse('2021-01-01');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->notVipCard->card_id);

        $this->assertEquals(ATMService::NORMAL_FEE, $fee);
    }

    public function test_it_calculate_fee_when_normal_card_in_normal_date_special_time_1()
    {
        list($minTime) = ATMService::TIME_PERIOD_1;
        $date = Carbon::parse('2021-09-22 ' . $minTime . ' +30 minutes');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->notVipCard->card_id);

        $this->assertEquals(ATMService::NORMAL_FEE, $fee);
    }

    public function test_it_calculate_fee_when_normal_card_in_normal_date_special_time_2()
    {
        list($minTime) = ATMService::TIME_PERIOD_2;
        $date = Carbon::parse('2021-09-22 ' . $minTime . ' +30 minutes');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->notVipCard->card_id);

        $this->assertEquals(ATMService::NO_FEE, $fee);
    }

    public function test_it_calculate_fee_when_normal_card_in_normal_date_special_time_3()
    {
        list($minTime) = ATMService::TIME_PERIOD_3;
        $date = Carbon::parse('2021-09-22 ' . $minTime . ' +30 minutes');
        Carbon::setTestNow($date);
        $fee = $this->atmService->calculate($this->notVipCard->card_id);

        $this->assertEquals(ATMService::NORMAL_FEE, $fee);
    }
}
