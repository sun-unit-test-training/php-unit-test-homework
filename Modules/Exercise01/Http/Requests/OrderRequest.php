<?php

namespace Modules\Exercise01\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Exercise01\Models\Voucher;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
            // TODO: abstraction for Rule:exists?
            'voucher' => ['nullable', Rule::exists(Voucher::getTableName(), 'code')->where('is_active', true)],
        ];
    }
}
