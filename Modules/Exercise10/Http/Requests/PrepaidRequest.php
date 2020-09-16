<?php

namespace Modules\Exercise10\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrepaidRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:' . implode(',', config('exercise10.card_type')),
            'price' => 'required|integer',
            'ballot' => 'boolean'
        ];
    }
}
