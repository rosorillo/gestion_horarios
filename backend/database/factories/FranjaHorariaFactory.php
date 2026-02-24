<?php

namespace Database\Factories;

use App\Models\FranjaHoraria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FranjaHoraria>
 */
class FranjaHorariaFactory extends Factory
{
    protected static int $orden = 0;

    public function definition(): array
    {
        $hora = 8 + (static::$orden % 6);
        static::$orden++;
        return [
            'hora_inicio' => sprintf('%02d:00:00', $hora),
            'hora_fin' => sprintf('%02d:00:00', $hora + 1),
            'orden' => static::$orden,
        ];
    }
}
