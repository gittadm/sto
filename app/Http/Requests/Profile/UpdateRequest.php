<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(id())
            ],
            'surname' => 'nullable|string',
            'middle_name' => 'nullable|string',
            'phone' => 'nullable|string',
            'about' => 'nullable|string',
            'born_at' => 'nullable|date_format:Y-m-d',
            'office_position' => 'nullable|string',
            'is_about_visible' => 'required|boolean',
            'is_born_at_visible' => 'required|boolean'
        ];
    }
}
