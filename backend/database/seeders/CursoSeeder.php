<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $nombres = ['1º ESO A', '1º ESO B', '2º ESO A', '3º ESO A', '4º ESO A', '1º Bach'];
        foreach ($nombres as $nombre) {
            Curso::factory()->create(['nombre' => $nombre]);
        }
    }
}
