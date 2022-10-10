<?php

namespace App\Http\Resources\Users;

use App\Models\RoleConst;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'title' => RoleConst::getTitleById($this->name)
        ];
    }
}
