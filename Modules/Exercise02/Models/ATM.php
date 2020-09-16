<?php

namespace Modules\Exercise02\Models;

use Illuminate\Database\Eloquent\Model;

class ATM extends Model
{
    protected $table = 'atms';

    protected $fillable = ['card_id', 'is_vip'];

    protected $casts = [
        'is_vip' => 'boolean',
    ];
}
