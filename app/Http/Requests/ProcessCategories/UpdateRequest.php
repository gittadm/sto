<?php

namespace App\Http\Requests\ProcessCategories;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|string',
            'appeal_reason_id' =>  'required|integer|exists:appeal_reasons,id',
        ];
    }
}
