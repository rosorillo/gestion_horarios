<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\AusenciaController;
use App\Http\Controllers\AusenciaDetalleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\FranjaHorariaController;
use App\Http\Controllers\HorarioController;
use Illuminate\Support\Facades\Route;

Route::apiResource('asignaturas', AsignaturaController::class);
Route::apiResource('cursos', CursoController::class);
Route::apiResource('aulas', AulaController::class);
Route::apiResource('franjas-horarias', FranjaHorariaController ::class);
Route::apiResource('horarios', HorarioController::class);
Route::apiResource('ausencias', AusenciaController::class);
Route::apiResource('ausencia-detalles', AusenciaDetalleController::class);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/usuarios', [AdminUserController::class, 'index']);
    Route::post('/usuarios', [AdminUserController::class, 'store']);
    Route::put('/usuarios/{id}', [AdminUserController::class, 'update']);
    Route::delete('/usuarios/{id}', [AdminUserController::class, 'destroy']);
});