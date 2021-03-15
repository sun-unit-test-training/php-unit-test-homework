<?php

namespace Modules\Exercise01\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Exercise01\Database\Factories\VoucherFactory;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $fillable = ['code', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getTableName()
    {
        return (new self)->getTable();
    }

    protected static function newFactory()
    {
        return VoucherFactory::new();
    }
}
