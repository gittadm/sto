<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class EngineVolumeSeeder extends Seeder
{
    /**
     * @return array
     */
    private function get(): array
    {
        $engineVolumes = [];

        for ($i = 0.9; $i < 3; $i += 0.1) {
            $engineVolumes[] = [
                'value' => $i
            ];
        }

        for ($i = 3; $i < 10; $i += 0.5) {
            $engineVolumes[] = [
                'value' => $i
            ];
        }

        return $engineVolumes;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('engine_volumes')->insert($this->get());
    }
}
