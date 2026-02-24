<?php

namespace Database\Factories;

use App\Models\Ausencia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ausencia>
 */
class AusenciaFactory extends Factory
{
    public function definition(): array
    {
        $inicio = fake()->dateTimeBetween('now', '+1 week');
        $fin = clone $inicio;
        $fin->modify('+' . fake()->numberBetween(1, 3) . ' days');
        return [
            'usuario_id' => User::factory(),
            'fecha_inicio' => $inicio,
            'fecha_fin' => $fin,
            'motivo' => fake()->randomElement([
                'Enfermedad', 'Cita médica', 'Asuntos personales', 'Formación', 'Otros',
            ]),
        ];
    }
}
