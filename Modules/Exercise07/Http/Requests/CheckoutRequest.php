<?php

namespace Modules\Exercise07\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function rules()
    {
        return [
            'amount' => ['required', 'integer', 'min:1'],
        ];
    }
}
