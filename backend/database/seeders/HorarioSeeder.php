<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Curso;
use App\Models\FranjaHoraria;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        $profesores = User::where('rol', 'profesor')->get();
        $asignaturas = Asignatura::all();
        $cursos = Curso::all();
        $aulas = Aula::all();
        $franjas = FranjaHoraria::all();

        if ($profesores->isEmpty() || $franjas->isEmpty() || $asignaturas->isEmpty() || $cursos->isEmpty() || $aulas->isEmpty()) {
            return;
        }

        $diaSemana = 1;
        foreach ($profesores->take(5) as $profesor) {
            Horario::factory()->create([
                'usuario_id' => $profesor->id,
                'asignatura_id' => $asignaturas->random()->id,
                'curso_id' => $cursos->random()->id,
                'aula_id' => $aulas->random()->id,
                'franja_id' => $franjas->random()->id,
                'dia_semana' => $diaSemana,
            ]);
            $diaSemana++;
        }
    }
}
