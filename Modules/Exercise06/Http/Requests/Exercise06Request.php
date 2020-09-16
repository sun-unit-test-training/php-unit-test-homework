<?php

namespace Modules\Exercise06\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Exercise06Request extends FormRequest
{
    public function rules()
    {
        return [
            'bill' => 'required|integer|min:0',
            'has_watch' => 'nullable|boolean',
        ];
    }
}
