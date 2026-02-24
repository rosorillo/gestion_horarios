<?php

namespace Database\Factories;

use App\Models\Ausencia;
use App\Models\AusenciaDetalle;
use App\Models\Horario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AusenciaDetalle>
 */
class AusenciaDetalleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ausencia_id' => Ausencia::factory(),
            'horario_id' => Horario::factory(),
            'fecha' => fake()->dateTimeBetween('now', '+1 week'),
            'tareas' => fake()->sentence(8),
        ];
    }
}
