<?php

use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\AusenciaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\FranjaHorariaController;
use App\Http\Controllers\HorarioController;
use Illuminate\Support\Facades\Route;

Route::apiResource('asignaturas', AsignaturaController::class);
Route::apiResource('cursos', CursoController::class);
Route::apiResource('aulas', AulaController::class);
Route::apiResource('franjashorarias', FranjaHorariaController ::class);
Route::apiResource('horarios', HorarioController::class);
Route::apiResource('ausencias', AusenciaController::class);