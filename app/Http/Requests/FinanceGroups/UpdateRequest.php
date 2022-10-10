<?php

namespace App\Http\Requests\FinanceGroups;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('finance_groups', 'name')->ignore($this->finance_group)
            ]
        ];
    }
}
