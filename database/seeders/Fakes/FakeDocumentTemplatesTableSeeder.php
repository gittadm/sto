<?php

namespace Database\Seeders\Fakes;

use App\Models\DocumentTemplate;
use Illuminate\Database\Seeder;

class FakeDocumentTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentTemplate::factory()->count(15)->create();
    }
}
