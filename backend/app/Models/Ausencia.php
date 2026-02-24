<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ausencia extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'fecha_inicio',
        'fecha_fin',
        'motivo'
    ];

    public function ausenciaDetalles() {
        return $this->hasMany(AusenciaDetalle::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
