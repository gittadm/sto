<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class FuelSeeder extends Seeder
{
    /**
     * @return array
     */
    private function get(): array
    {
        $fuelNames = [
            'Бензин',
            'Дизель',
            'Электро',
            'Другое',
        ];

        $fuels = [];

        foreach ($fuelNames as $fuelName) {
            $fuels[] = ['name' => $fuelName];
        }

        return $fuels;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuels')->insert($this->get());
    }
}
