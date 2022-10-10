<?php

namespace App\Http\Requests\Finances;

use App\Models\Finance;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'operation_type' => [
                'required',
                'string',
                Rule::in([Finance::OPERATION_OUTPUT, Finance::OPERATION_INPUT])
            ],
            'sum' => 'required|integer|min:0',
            'finance_group_id' => [
                'required',
                'integer',
                Rule::exists('finance_groups', 'id')
            ],
            'department_id' => 'nullable|integer|exists:departments,id'
        ];
    }
}
