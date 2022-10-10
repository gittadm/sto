<?php

namespace Database\Seeders\Fakes;

use Database\Factories\CarMarkFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakeCarMarksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $markNames = (new CarMarkFactory())->markNames;
        $marks = [];
        foreach ($markNames as $markName) {
            $marks[] = ['name' => $markName];
        }

        DB::table('car_marks')->insert($marks);
    }
}
