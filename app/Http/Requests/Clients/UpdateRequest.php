<?php

namespace App\Http\Requests\Clients;

use App\Models\Client;
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
            'name' => 'required|string',
            'surname' => 'required|string',
            'middle_name' => 'nullable|string',
            'gender' => [
                'nullable',
                'string',
                Rule::in([Client::GENDER_FEMALE, Client::GENDER_MALE])
            ],
            'address' => 'nullable|string',
            'passport' => 'nullable|string',
            'notes' => 'nullable|string',
            'born_at' => 'nullable|date_format:Y-m-d',
            'phones' => 'required|array|min:1',
            'phones.*' => 'required|string',
            'emails' => 'nullable|array',
            'emails.*' => 'required|string',
            'city_id' => [
                'nullable',
                'integer',
                Rule::exists('cities', 'id')
            ],
            'department_id' => [
                'required',
                'integer',
                Rule::exists('departments', 'id')
            ],
        ];
    }
}
