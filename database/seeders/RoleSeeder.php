<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use App\Models\RoleConst;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (RoleConst::getPermissions() as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => RoleConst::GUARD_NAME]);
        }

        Role::create(['name' => RoleConst::ROLE_ADMIN, 'title' => 'Администратор', 'guard_name' => RoleConst::GUARD_NAME])
            ->givePermissionTo(Permission::all());
    }
}
