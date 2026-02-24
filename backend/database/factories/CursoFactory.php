<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curso>
 */
class CursoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->randomElement(['1º ESO', '2º ESO', '3º ESO', '4º ESO', '1º Bach', '2º Bach']) . fake()->optional(0.2)->randomElement([' A', ' B', ' C']),
        ];
    }
}
