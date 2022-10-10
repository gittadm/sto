<?php

namespace App\Http\Requests\Storages;

use App\Exceptions\CustomValidationException;
use App\Models\Storage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * @throws CustomValidationException
     */
    protected function prepareForValidation()
    {
        if (isset($this->city_id) && isset($this->name)) {
            if (Storage::where('name', $this->name)->where('city_id', $this->city_id)->exists()) {
                throw new CustomValidationException('Для указанного города склад с указанным названием уже существует');
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
            'city_id' => [
                'required',
                'integer',
                Rule::exists('cities', 'id')
            ]
        ];
    }
}
