<?php

namespace App\Http\Requests\TempFiles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Task;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'files' => 'required|array',
            'files.*' => 'required|file'
        ];
    }
}
