<?php

namespace App\Http\Requests\ProcessTasks\Checkboxes;

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
            'description' => 'required|string',
            'is_checked' => 'required|boolean',
        ];
    }
}
