<?php

namespace Database\Seeders\Fakes;

use App\Models\Department;
use App\Models\Role;
use App\Models\RoleConst;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Arr;
use DB;
use Spatie\Permission\PermissionRegistrar;

class FakeUsersTableSeeder extends Seeder
{
    public const DB_TOKEN = 'bb7dc1cd92ecd32fd31b2bb3f3d2551fc458488f36af6cddaeec73420e39b1f1';
    public const FRONTEND_TOKEN = '2|Vdl7CeO6oAn5jmkpdkWYvxyLQSBfjxJTkAK6nS1i';

    private function createAdmin(): void
    {
        User::factory()->create(
            [
                'name' => 'Петр',
                'middle_name' => 'Иванович',
                'surname' => 'Леонидов',
                'email' => 'admin@admin.ru',
                'is_active' => true,
                'department_id' => null
            ]
        );
    }

    private function addUserRoles(): void
    {
        $users = User::all();
        $roles = Role::notAdmin()->get();

        foreach ($users as $user) {
            if ($user->email === 'admin@admin.ru') {
                $user->assignRole(Role::where('name', RoleConst::ROLE_ADMIN)->first());
            } elseif ($user->email === 'user@user.ru') {
                $user->assignRole(Role::where('name', 'director')->first());
            } else {
                $user->assignRole($roles->random());
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createAdmin();

        $departmentIds = Department::pluck('id')->toArray();

        User::factory()->create(
            [
                'name' => 'Иван',
                'middle_name' => 'Петрович',
                'surname' => 'Сидоров',
                'email' => 'user@user.ru',
                'is_active' => true,
                'department_id' => Arr::random($departmentIds)
            ]
        );

        DB::table('personal_access_tokens')->insert(
            [
                'id' => 2,
                'tokenable_type' => 'App\Models\User',
                'tokenable_id' => 2,
                'name' => 'api_token',
                'token' => self::DB_TOKEN,
                'abilities' => json_encode(["*"]),
                'last_used_at' => null,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ]
        );

        User::factory()->count(100)
            ->state(
                new Sequence(
                    function () use ($departmentIds) {
                        return ['department_id' => Arr::random($departmentIds)];
                    },
                )
            )->create();

        $this->addUserRoles();
    }
}
