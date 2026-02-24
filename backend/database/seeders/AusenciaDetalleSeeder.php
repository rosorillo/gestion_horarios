<?php

namespace Database\Seeders;

use App\Models\Ausencia;
use App\Models\AusenciaDetalle;
use App\Models\Horario;
use Illuminate\Database\Seeder;

class AusenciaDetalleSeeder extends Seeder
{
    public function run(): void
    {
        $ausencias = Ausencia::all();
        foreach ($ausencias as $ausencia) {
            $horariosDelProfesor = Horario::where('usuario_id', $ausencia->usuario_id)->get();
            if ($horariosDelProfesor->isEmpty()) {
                continue;
            }
            $horario = $horariosDelProfesor->random();
            AusenciaDetalle::factory()->create([
                'ausencia_id' => $ausencia->id,
                'horario_id' => $horario->id,
                'fecha' => $ausencia->fecha_inicio,
                'tareas' => 'Repasar tema 5. Ejercicios 1 a 10 de la página 42.',
            ]);
        }
    }
}
