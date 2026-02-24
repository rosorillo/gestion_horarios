<?php

namespace Database\Factories;

use App\Models\Asignatura;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asignatura>
 */
class AsignaturaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->randomElement([
                'Matemáticas', 'Lengua', 'Inglés', 'Ciencias', 'Historia',
                'Educación Física', 'Música', 'Plástica', 'Tecnología', 'Francés',
            ]) . ' ' . fake()->optional(0.3)->numberBetween(1, 4),
        ];
    }
}
