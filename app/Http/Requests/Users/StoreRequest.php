<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(
            [
                'is_active' => !isset($this->is_active) || $this->is_active,
                'is_about_visible' => isset($this->is_about_visible) && $this->is_about_visible,
                'is_born_at_visible' => isset($this->is_born_at_visible) && $this->is_born_at_visible,
            ]
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'password' => 'required|string|min:8',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
            'department_id' => 'required|integer|exists:departments,id',
            'role_id' => 'required|integer|exists:roles,id',
            'surname' => 'nullable|string',
            'middle_name' => 'nullable|string',
            'phone' => 'nullable|string',
            'about' => 'nullable|string',
            'born_at' => 'nullable|date_format:Y-m-d',
            'office_position' => 'nullable|string',
            'is_about_visible' => 'required|boolean',
            'is_born_at_visible' => 'required|boolean',
            'is_active' => 'required|boolean'
        ];
    }
}
