<?php

namespace App\Http\Requests\CarModels;

use App\Exceptions\CustomValidationException;
use App\Models\CarModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * @throws CustomValidationException
     */
    protected function prepareForValidation()
    {
        if (isset($this->car_mark_id) && isset($this->name)) {
            if (CarModel::where('name', $this->name)->where('car_mark_id', $this->car_mark_id)->exists()) {
                throw new CustomValidationException('Для указанной марки модель с указанным названием уже существует');
            }
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
            'name' => [
                'required',
                'string'
            ],
            'car_mark_id' => [
                'required',
                'integer',
                Rule::exists('car_marks', 'id')
            ]
        ];
    }
}
