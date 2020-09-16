<?php

namespace Modules\Exercise02\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ATMRequest extends FormRequest
{
    public function rules()
    {
        return [
            'card_id' => 'required|exists:atms,card_id',
        ];
    }
}
