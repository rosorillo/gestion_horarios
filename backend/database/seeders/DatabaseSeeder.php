<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AsignaturaSeeder::class,
            CursoSeeder::class,
            AulaSeeder::class,
            FranjaHorariaSeeder::class,
            UserSeeder::class,
            HorarioSeeder::class,
            AusenciaSeeder::class,
            AusenciaDetalleSeeder::class,
        ]);
    }
}
