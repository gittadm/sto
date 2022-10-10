<?php

namespace App\Http\Requests\Roles;

use App\Models\RoleConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => [
                'required',
                'string',
                Rule::unique('roles', 'title')
            ],
            'permissions' => 'required|array',
            'permissions.*' => [
                'nullable',
                'string',
                Rule::in(RoleConst::getPermissions())
            ]
        ];
    }
}
