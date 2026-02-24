<?php

namespace Database\Factories;

use App\Models\Aula;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aula>
 */
class AulaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => 'Aula ' . fake()->unique()->numberBetween(101, 199),
        ];
    }
}
