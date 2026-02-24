<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AusenciaDetalle extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'ausencia_id',
        'horario_id',
        'fecha',
        'tareas'
    ];

    public function ausencia() {
        return $this->belongsTo(Ausencia::class);
    }

    public function horario() {
        return $this->belongsTo(Horario::class);
    }
}
