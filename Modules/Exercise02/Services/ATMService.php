<?php

namespace Modules\Exercise02\Services;

use Carbon\Carbon;
use Modules\Exercise02\Models\ATM;
use InvalidArgumentException;
use Modules\Exercise02\Repositories\ATMRepository;

class ATMService
{
    const NORMAL_FEE = 110;
    const NO_FEE = 0;
    const TIME_PERIOD_1 = ['00:00', '8:44'];
    const TIME_PERIOD_2 = ['08:45', '17:59'];
    const TIME_PERIOD_3 = ['18:00', '23:59'];
    const HOLIDAYS = ['01-01', '30-04', '01-05'];

    /**
     * @var ATMRepository
     */
    protected $atmRepository;

    /**
     * ProductService constructor.
     * @param ATMRepository $ATMRepository
     */
    public function __construct(ATMRepository $atmRepository)
    {
        $this->atmRepository = $atmRepository;
    }

    /**
     * Calcuate ATM Fee
     *
     *
     * @return null
     */
    public function calculate($cardId)
    {
        $card = $this->atmRepository->find($cardId);

        if (!$card) {
            throw new InvalidArgumentException('Card ID is invalid!');
        }

        if ($card->is_vip) {
            return self::NO_FEE;
        }

        // Nếu là ngày lễ trả về normalFee
        $today = Carbon::now();
        if (in_array($today->format('d-m'), self::HOLIDAYS) || $today->isWeekend()) {
            return self::NORMAL_FEE;
        }

        $timeNow = $today->format('H:i');
        list($minTimePeriod2, $maxTimePeriod2) = self::TIME_PERIOD_2;
        if ($timeNow >= $minTimePeriod2 && $timeNow <= $maxTimePeriod2) {
            return self::NO_FEE;
        }

        return self::NORMAL_FEE;
    }
}
