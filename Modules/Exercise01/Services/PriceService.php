<?php

namespace Modules\Exercise01\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Exercise01\Services\DTO\Price;

class PriceService
{
    const UNIT_PRICE = 490;
    const VOUCHER_UNIT_PRICE = 100;
    const SPECIAL_TIME_UNIT_PRICE = 290;
    const SPECIAL_TIME_PERIOD = ['16:00', '17:59'];

    /**
     * Calcuate price
     *
     * @param int $quantity
     * @param boolean $usedVoucher
     *
     * @return Price
     */
    public function calculate($quantity, $usedVoucher)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Quantity must be greater than 0');
        }

        $baseTotal = $quantity * self::UNIT_PRICE;

        // Voucher is only applied for the first one
        $voucherDiscount = 0;
        if ($usedVoucher) {
            $voucherDiscount = self::UNIT_PRICE - self::VOUCHER_UNIT_PRICE;
            $quantity -= 1;
        }

        $specialTimeDiscount = 0;
        if ($quantity >= 1) {
            $timeNow = Carbon::now()->format('H:i');
            list($minSpecialTime, $maxSpecialTime) = self::SPECIAL_TIME_PERIOD;
            if ($timeNow >= $minSpecialTime && $timeNow <= $maxSpecialTime) {
                $specialTimeDiscount = $quantity * (
                    self::UNIT_PRICE - self::SPECIAL_TIME_UNIT_PRICE
                );
            }
        }

        $total = $baseTotal - $voucherDiscount - $specialTimeDiscount;

        return new Price($total, $voucherDiscount, $specialTimeDiscount);
    }
}
