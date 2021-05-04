<?php

namespace Modules\Exercise08\Services;

use Carbon\Carbon;
use InvalidArgumentException;

class TicketService
{
    const BASE_PRICE = 1800;
    const PRICE_IN_TUESDAY = 1200;
    const PRICE_FEMALE_FRIDAY = 1400;
    const PRICE_OVER_65 = 1600;
    const MIN_AGE = 0;
    const MAX_AGE = 120;

    /**
     * Calculate price
     *
     * @param array $input
     *
     * @return int|boolean $data
     */

    public function calculatePrice($input)
    {
        $dayOfWeek = Carbon::parse($input['booking_date'])->dayOfWeek + 1;
        $dataPrice = [];

        if ($input['age'] < self::MIN_AGE || $input['age'] > self::MAX_AGE) {
            throw new InvalidArgumentException('The age must be from ' . self::MIN_AGE . ' to ' . self::MAX_AGE);
        }

        if ($input['age'] < 13) {
            return self::BASE_PRICE * 0.5;
        }

        if ($dayOfWeek == 3) {
            return  self::PRICE_IN_TUESDAY;
        }

        if ($input['gender'] == config('exercise08.gender.female') && $dayOfWeek == 6) {
            $dataPrice[] = self::PRICE_FEMALE_FRIDAY;
        }

        if ($input['age'] > 65) {
            $dataPrice[] = self::PRICE_OVER_65;
        }

        return $dataPrice ? min($dataPrice) : self::BASE_PRICE;
    }
}
