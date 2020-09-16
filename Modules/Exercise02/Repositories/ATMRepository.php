<?php

namespace Modules\Exercise02\Repositories;

use Modules\Exercise02\Models\ATM;

/**
 * Class ProductRepository
 * @package Modules\Exercise02\Repositories
 */
class ATMRepository
{
    /**
     * ProductRepository constructor.
     * @param ATM $model
     */
    public function __construct(ATM $model)
    {
        $this->model = $model;
    }

    /**
     * find a record
     *
     * @return ATM
     */
    public function find($cardId)
    {
        return $this->model->where('card_id', $cardId)->first();
    }
}
