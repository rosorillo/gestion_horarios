<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'asignatura_id',
        'curso_id',
        'aula_id',
        'franja_id',
        'dia_semana'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function asignatura() {
        return $this->belongsTo(Asignatura::class);
    }

    public function curso() {
        return $this->belongsTo(Curso::class);
    }

    public function aula() {
        return $this->belongsTo(Aula::class);
    }

    public function franjaHoraria() {
        return $this->belongsTo(FranjaHoraria::class);
    }
}
