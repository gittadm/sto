<?php

namespace App\Http\Requests\Pipelines;

use App\Models\Pipeline;
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
            'type' => [
                'required',
                'string',
                Rule::in(Pipeline::getModelMapAliases())
            ]
        ];
    }
}
