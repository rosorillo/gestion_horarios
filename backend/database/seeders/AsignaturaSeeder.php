<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use Illuminate\Database\Seeder;

class AsignaturaSeeder extends Seeder
{
    public function run(): void
    {
        $nombres = ['Matemáticas', 'Lengua', 'Inglés', 'Ciencias', 'Historia', 'Educación Física', 'Tecnología', 'Música'];
        foreach ($nombres as $nombre) {
            Asignatura::factory()->create(['nombre' => $nombre]);
        }
    }
}
