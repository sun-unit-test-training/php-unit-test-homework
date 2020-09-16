<?php

namespace Modules\Exercise01\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = ['code', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getTableName()
    {
        return (new self)->getTable();
    }
}
