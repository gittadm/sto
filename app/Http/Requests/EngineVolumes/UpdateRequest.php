<?php

namespace App\Http\Requests\EngineVolumes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
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
        if (isset($this->value)) {
            $value = str_replace(",", ".", $this->value);
            $dotPosition = strpos($value, '.');
            if ($dotPosition !== false) {
                $value = Str::substr($value, 0, $dotPosition + 2);
            }
            $this->merge(
                [
                    'value' => $value
                ]
            );
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'numeric',
                'min:0',
                'max:10',
                Rule::unique('engine_volumes', 'value')->ignore($this->engine_volume)
            ]
        ];
    }
}
