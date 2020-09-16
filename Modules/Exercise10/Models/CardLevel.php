<?php

namespace Modules\Exercise10\Models;

use Illuminate\Database\Eloquent\Model;

class CardLevel extends Model
{
    protected $fillable = [
        'type',
        'amount_limit',
        'bonus',
    ];
}
