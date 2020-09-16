<?php

namespace Modules\Exercise10\Repositories;

use Modules\Exercise10\Models\CardLevel;
use Modules\Exercise10\Contracts\Repositories\CardLevelRepository;

class CardLevelEloquent implements CardLevelRepository
{
    protected $model;

    public function __construct(CardLevel $cardLevel)
    {
        $this->model = $cardLevel;
    }

    public function findBonus($type, $amountLimit, $columns = ['*'])
    {
        return $this->model
            ->where('type', $type)
            ->where('amount_limit', '<=', $amountLimit)
            ->orderByDesc('amount_limit')
            ->first($columns);
    }
}
