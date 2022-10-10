<?php

namespace App\Http\Requests\Tasks;

use App\Models\Task;
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
            'status' => [
                'required',
                'string',
                Rule::in(Task::getStatuses())
            ],
            'checkboxes' => 'required|array',
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
            'delete_file_ids' => 'nullable|array',
            'delete_file_ids.*' => 'integer',
            'temp_file_ids' => 'nullable|array',
            'temp_file_ids.*' => 'integer'
        ];
    }
}
