<?php

namespace Database\Seeders;

use App\Models\FranjaHoraria;
use Illuminate\Database\Seeder;

class FranjaHorariaSeeder extends Seeder
{
    public function run(): void
    {
        $franjas = [
            ['08:00:00', '09:00:00', 1],
            ['09:00:00', '10:00:00', 2],
            ['10:00:00', '11:00:00', 3],
            ['11:30:00', '12:30:00', 4],
            ['12:30:00', '13:30:00', 5],
        ];
        foreach ($franjas as [$inicio, $fin, $orden]) {
            FranjaHoraria::factory()->create([
                'hora_inicio' => $inicio,
                'hora_fin' => $fin,
                'orden' => $orden,
            ]);
        }
    }
}
