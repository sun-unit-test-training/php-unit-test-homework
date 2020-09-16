<?php

namespace Modules\Exercise10\Contracts\Repositories;

interface CardLevelRepository
{
    /**
     * [findBonus]
     * @param  [integer]    $type
     * @param  [integer]    $amountLimit
     * @param  [array]      $columns
     *
     * @return [Entity]
     */
    public function findBonus($type, $amountLimit, $columns = ['*']);
}
