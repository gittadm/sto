<?php

namespace App\Http\Requests\Tasks;

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
            'status' => [
                'nullable',
                'string',
                Rule::in(Task::getStatuses())
            ],
            'position' => 'required|integer|min:0',
            'user_id' => 'required|integer|exists:users,id',
            'deadline_at' => 'nullable|date_format:Y-m-d',
            'start_at' => 'nullable|date_format:Y-m-d',
            'end_at' => 'nullable|date_format:Y-m-d',
            'description' => 'nullable|string',
            'order_id' => 'nullable|integer|exists:orders,id',
            'pipelines' => 'required|array',
            'pipelines.*.pipeline_id' => 'nullable|integer|exists:pipelines,id',
            'pipelines.*.stage_id' => 'nullable|integer|exists:stages,id',
            'checkboxes' => 'required|array',
            'checkboxes.*' => 'nullable|string',
            'temp_file_ids' => 'nullable|array',
            'temp_file_ids.*' => 'integer'
        ];
    }
}
