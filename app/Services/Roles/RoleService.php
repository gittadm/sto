<?php

namespace App\Services\Roles;

use App\Exceptions\CustomValidationException;
use App\Exceptions\UsedInOtherTableException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use DB;

class RoleService
{
    /**
     * @return Collection
     */
    public function getAllWithPermissions(): Collection
    {
        return Role::with('permissions')->orderBy('title')->get();
    }

    /**
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function store(array $data)
    {
        return DB::transaction(
            function () use ($data) {
                $role = Role::create(
                    [
                        'title' => $data['title'],
                        'name' => Role::genName($data['title'])
                    ]
                );
                $role->syncPermissions($data['permissions']);

                return $role;
            }
        );
    }

    /**
     * @param  Role  $role
     * @param  array  $data
     * @return mixed
     * @throws CustomValidationException
     * @throws \Throwable
     */
    public function update(Role $role, array $data)
    {
        if ($role->is_admin) {
            throw new CustomValidationException('Роль администратора нельзя редактировать');
        }

        return DB::transaction(
            function () use ($data, &$role) {
                if ($role->title !== $data['title']) {
                    $role->update(
                        [
                            'title' => $data['title'],
                            'name' => Role::genName($data['title'], $role->id)
                        ]
                    );
                }
                $role->syncPermissions($data['permissions']);

                return $role;
            }
        );
    }

    /**
     * @param  Role  $role
     * @throws CustomValidationException
     * @throws UsedInOtherTableException
     */
    public function destroy(Role $role): void
    {
        if (User::role($role->name)->exists()) {
            throw new UsedInOtherTableException(
                'Роль нельзя удалить, так как существует пользователь с такой ролью'
            );
        }

        if ($role->is_admin) {
            throw new CustomValidationException('Роль администратора нельзя удалить');
        }

        $role->delete();
    }
}
