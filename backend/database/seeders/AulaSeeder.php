<?php

namespace Database\Seeders;

use App\Models\Aula;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['101', '102', '103', '201', '202', '203'] as $num) {
            Aula::factory()->create(['nombre' => "Aula $num"]);
        }
    }
}
