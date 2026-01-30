<?php

use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('asignaturas', AsignaturaController::class);
Route::apiResource('cursos', CursoController::class);