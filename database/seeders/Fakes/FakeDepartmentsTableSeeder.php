<?php

namespace Database\Seeders\Fakes;

use Illuminate\Database\Seeder;
use App\Models\Department;

class FakeDepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::factory()->count(5)->create();
    }
}
