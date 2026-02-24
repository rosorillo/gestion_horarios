<?php

namespace Database\Factories;

use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Curso;
use App\Models\FranjaHoraria;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Horario>
 */
class HorarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(),
            'asignatura_id' => Asignatura::factory(),
            'curso_id' => Curso::factory(),
            'aula_id' => Aula::factory(),
            'franja_id' => FranjaHoraria::factory(),
            'dia_semana' => fake()->unique()->numberBetween(1, 7),
        ];
    }
}
