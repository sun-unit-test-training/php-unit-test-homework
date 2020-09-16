<?php

namespace Modules\Exercise03\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ];
    }
}
