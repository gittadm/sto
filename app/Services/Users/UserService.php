<?php

namespace App\Services\Users;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Role;
use App\Models\User;
use DB;

class UserService
{
    /**
     * @param  array  $filter
     * @return Collection|array
     */
    public function getAllWithRoles(array $filter): Collection|array
    {
        $users = User::with('department', 'roles');

        if (!empty($filter['active'])) {
            if ($filter['active'] == '1') {
                $users->active();
            } elseif ($filter['active'] == '0') {
                $users->notActive();
            }
        }

        if (!empty($filter['department_id'])) {
            $users->where('department_id', $filter['department_id']);
        }

        if (!empty($filter['name'])) {
            $users->where(
                function ($query) use ($filter) {
                    $search = '%'.$filter['name'].'%';
                    $query->where('name', 'like', $search)
                        ->orWhere('surname', 'like', $search)
                        ->orWhere('middle_name', 'like', $search);
                }
            );
        }

        if (!empty($filter['order'])) {
            if ($filter['order'] == 'surname') {
                $users->orderBy('surname')->orderBy('name');
            } elseif ($filter['order'] == 'department') {
                $users->join('departments', 'departments.id', '=', 'users.department_id')
                    ->select('departments.*', 'users.*')
                    ->orderBy('departments.name', 'ASC');
            } else { // id or other
                $users->orderBy('id', 'desc');
            }
        } else {
            $users->orderBy('id', 'desc');
        }

        return $users->get();
    }

    /**
     * @param  array  $data
     * @return User
     * @throws \Throwable
     */
    public function store(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $role = Role::findOrFail($data['role_id']);
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            $user->assignRole($role->name);

            return $user;
        });
    }

    /**
     * @param  User  $user
     * @param  array  $data
     * @return User
     * @throws \Throwable
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use (&$user, $data) {
            $role = Role::findOrFail($data['role_id']);

            $user->fill($data);
            $user->save();

            $user->syncRoles([$role->name]);

            return $user;
        });
    }

    /**
     * @param  User  $user
     */
    public function destroy(User $user): void
    {
        $user->delete();
    }
}
