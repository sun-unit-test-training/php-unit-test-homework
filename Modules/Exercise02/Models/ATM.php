<?php

namespace Modules\Exercise02\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Exercise02\Database\Factories\ATMFactory;

class ATM extends Model
{
    use HasFactory;

    protected $table = 'atms';

    protected $fillable = ['card_id', 'is_vip'];

    protected $casts = [
        'is_vip' => 'boolean',
    ];

    protected static function newFactory()
    {
        return ATMFactory::new();
    }
}
