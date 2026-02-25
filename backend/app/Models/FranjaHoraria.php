<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranjaHoraria extends Model
{
    use HasFactory;

    protected $table = 'franjas_horarias';

    protected $fillable = [
        'hora_inicio',
        'hora_fin',
        'orden'
    ];

    public function horarios() {
        return $this->hasMany(Horario::class, 'franja_id');
    }
}
