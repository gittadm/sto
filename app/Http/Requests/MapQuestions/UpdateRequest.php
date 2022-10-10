<?php

namespace App\Http\Requests\MapQuestions;

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
            'question' => 'required|string',
            'answers_and_recommendations' => 'required|array',
        ];
    }
}
