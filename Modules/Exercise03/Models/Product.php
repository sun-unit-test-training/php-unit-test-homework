<?php

namespace Modules\Exercise03\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Exercise03\Database\Factories\ProductFactory;

/**
 * @property string $name
 * @property int $type
 */
class Product extends Model
{
    use HasFactory;

    const CRAVAT_TYPE = 1;
    const WHITE_SHIRT_TYPE = 2;
    const OTHER_TYPE = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise03_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type'];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
