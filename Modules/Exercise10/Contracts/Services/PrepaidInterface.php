<?php

namespace Modules\Exercise10\Contracts\Services;

interface PrepaidInterface
{
    /**
     * [getAmountBonus]
     * @param  [array]      $data from request
     *
     * @return [array]
     * [
     *      'type',
     *      'price',
     *      'ballot',
     *      'bonus',
     *      'amount',
     * ]
     */
    public function getAmountBonus(array $data): array;
}
