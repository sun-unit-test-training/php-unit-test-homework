<?php
declare(strict_types=1);

namespace Modules\Exercise01\Feature\Tests\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Exercise01\Models\Voucher;
use Modules\Exercise01\Services\DTO\Price;
use Modules\Exercise01\Services\PriceService;
use Tests\TestCase;

class PriceServiceTest extends TestCase
{
    protected $priceService;
    protected $voucherActive;
    protected $arrayQty = [1, 5, 10.5];

    protected function setUp(): void
    {
        parent::setUp();
        $this->priceService = new PriceService();
        $this->voucherActive = Voucher::factory()->active()->create()->fresh();
    }

    public function testQuantityLessEqualThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->priceService->calculate(-1, '');
    }

    public function testNormalCase()
    {
        $response = $this->priceService->calculate(1, '');
        $this->assertInstanceOf(Price::class, $response);
        $this->assertEquals(new Price(PriceService::UNIT_PRICE, 0, 0), $response);
    }

    public function testSpecialTimeCase()
    {
        $this->getSpecialTime();

        foreach ($this->arrayQty as $qty) {
            $response = $this->priceService->calculate($qty, '');

            $price = PriceService::SPECIAL_TIME_UNIT_PRICE * $qty;
            $specialTimeDiscount = (PriceService::UNIT_PRICE - PriceService::SPECIAL_TIME_UNIT_PRICE) * $qty;

            $this->assertInstanceOf(Price::class, $response);
            $this->assertEquals(new Price($price, 0, $specialTimeDiscount), $response);
        }
    }

    public function testVoucherCase()
    {
        foreach ($this->arrayQty as $qty) {
            $response = $this->priceService->calculate($qty, $this->voucherActive->code);

            $price = PriceService::UNIT_PRICE * $qty - (PriceService::UNIT_PRICE - PriceService::VOUCHER_UNIT_PRICE);
            $voucherDiscount = PriceService::UNIT_PRICE - PriceService::VOUCHER_UNIT_PRICE;

            $this->assertInstanceOf(Price::class, $response);
            $this->assertEquals(new Price($price, $voucherDiscount, 0), $response);
        }
    }

    public function testVoucherAndSpecialTimeCase()
    {
        $this->getSpecialTime();

        foreach ($this->arrayQty as $qty) {
            $response = $this->priceService->calculate($qty, $this->voucherActive->code);

            $price = PriceService::SPECIAL_TIME_UNIT_PRICE * ($qty - 1) + PriceService::VOUCHER_UNIT_PRICE;
            $voucherDiscount = PriceService::UNIT_PRICE - PriceService::VOUCHER_UNIT_PRICE;
            $specialTimeDiscount = (PriceService::UNIT_PRICE - PriceService::SPECIAL_TIME_UNIT_PRICE) * ($qty - 1);

            if ($qty == 1) {
                $price = PriceService::VOUCHER_UNIT_PRICE;
                $specialTimeDiscount = 0;
            }

            $this->assertInstanceOf(Price::class, $response);
            $this->assertEquals(new Price($price, $voucherDiscount, $specialTimeDiscount), $response);
        }
    }

    public function getSpecialTime()
    {
        list($minTime) = PriceService::SPECIAL_TIME_PERIOD;
        $minTime = $minTime . '+5 minutes';
        $date = Carbon::parse('2022-05-19' . $minTime);
        Carbon::setTestNow($date);
    }
}
