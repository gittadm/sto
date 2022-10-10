<?php

namespace Database\Seeders\Fakes;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use App\Models\RoleConst;

class FakeRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'slecar', 'title' => 'Слесарь', 'guard_name' => RoleConst::GUARD_NAME])
            ->givePermissionTo([RoleConst::PERMISSION_ROLES_CRUD, RoleConst::PERMISSION_DEPARTMENTS_CRUD]);

        Role::create(['name' => 'manager', 'title' => 'Менеджер', 'guard_name' => RoleConst::GUARD_NAME])
            ->givePermissionTo([RoleConst::PERMISSION_ROLES_CRUD, RoleConst::PERMISSION_USERS_CRUD]);

        Role::create(['name' => 'director', 'title' => 'Директор', 'guard_name' => RoleConst::GUARD_NAME])
            ->givePermissionTo(RoleConst::getPermissions());
    }
}
