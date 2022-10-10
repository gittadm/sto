<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\Departments\DepartmentResource;
use App\Http\Resources\Users\UserPermissionResource;
use App\Http\Resources\Users\UserRoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'middle_name' => $this->middle_name,
            'phone' => $this->phone,
            'born_at' => db_to_date($this->born_at),
            'office_position' => $this->office_position,
            'about' => $this->about,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'is_about_visible' => $this->is_about_visible,
            'is_born_at_visible' => $this->is_born_at_visible,
            'login_at' => db_to_date($this->login_at),
            'avatar' => $this->avatar_url,
            'department' => DepartmentResource::make($this->department),
            'roles' => UserRoleResource::collection($this->roles),
            'permissions' => UserPermissionResource::collection($this->getPermissionsViaRoles())
        ];
    }
}
