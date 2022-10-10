<?php

namespace App\Http\Requests\Cars;

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
            'number' => [
                'required',
                'string',
                Rule::unique('cars', 'number')->ignore($this->car)
            ],
            'vin' => [
                'nullable',
                'string',
                Rule::unique('cars', 'vin')->ignore($this->car)
            ],
            'year' => 'nullable|integer|min:1950|max:'.(1 + (int)date('Y')),
            'body' => 'nullable|string',
            'color' => 'nullable|string',
            'notes' => 'nullable|string',
            'fuel_id' => 'nullable|integer|exists:fuels,id',
            'engine_volume_id' => 'nullable|integer|exists:engine_volumes,id',
            'client_id' => 'required|integer|exists:clients,id',
            'car_model_id' => 'required|integer|exists:car_models,id',
        ];
    }
}
