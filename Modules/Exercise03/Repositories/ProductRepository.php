<?php

namespace Modules\Exercise03\Repositories;

use Modules\Exercise03\Models\Product;

/**
 * Class ProductRepository
 * @package Modules\Exercise03\Repositories
 */
class ProductRepository
{
    /**
     * ProductRepository constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Get all of records
     *
     * @return \Illuminate\Database\Eloquent\Collection|Product[]
     */
    public function all()
    {
        return $this->model->all();
    }
}
