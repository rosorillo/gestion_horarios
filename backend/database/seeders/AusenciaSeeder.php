<?php

namespace Database\Seeders;

use App\Models\Ausencia;
use App\Models\User;
use Illuminate\Database\Seeder;

class AusenciaSeeder extends Seeder
{
    public function run(): void
    {
        $profesores = User::where('rol', 'profesor')->get();
        if ($profesores->isEmpty()) {
            return;
        }

        foreach ($profesores->take(3) as $profesor) {
            Ausencia::factory()->count(1)->create([
                'usuario_id' => $profesor->id,
                'fecha_inicio' => now(),
                'fecha_fin' => now()->addDays(2),
                'motivo' => 'Enfermedad',
            ]);
        }
    }
}
