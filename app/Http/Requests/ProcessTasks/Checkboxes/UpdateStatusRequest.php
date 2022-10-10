<?php

namespace App\Http\Requests\ProcessTasks\Checkboxes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'is_checked' => 'required|boolean',
        ];
    }
}
