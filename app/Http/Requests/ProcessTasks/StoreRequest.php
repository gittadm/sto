<?php

namespace App\Http\Requests\ProcessTasks;

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
            'name' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'time' => 'nullable|date_format:Y-m-d',
            'position' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'order_id' => 'nullable|integer|exists:orders,id',
            'pipelines' => 'required|array',
            'pipelines.*.pipeline_id' => 'required|integer',
            'pipelines.*.stage_id' => 'nullable|integer',
            'checkboxes' => 'required|array',
            'checkboxes.*' => 'nullable|string',
            'temp_file_ids' => 'nullable|array',
            'temp_file_ids.*' => 'integer'
        ];
    }
}
