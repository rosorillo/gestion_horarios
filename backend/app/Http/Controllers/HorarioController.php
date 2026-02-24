<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     * Profesor: solo su horario. Admin: todos.
     */
    public function index(Request $request)
    {
        $query = Horario::with([
            'user',
            'asignatura',
            'curso',
            'aula',
            'franjaHoraria'
        ]);

        if ($request->user()->rol === 'profesor') {
            $query->where('usuario_id', $request->user()->id);
        }

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuarioId = $request->user()->rol === 'admin'
            ? $request->input('usuario_id')
            : $request->user()->id;

        if ($request->user()->rol === 'profesor') {
            $request->merge(['usuario_id' => $usuarioId]);
        }

        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'curso_id' => 'required|exists:cursos,id',
            'aula_id' => 'required|exists:aulas,id',
            'franja_id' => 'required|exists:franjas_horarias,id',
            'dia_semana' => 'required|string'
        ]);

        $horario = Horario::create([
            'usuario_id' => $usuarioId,
            'asignatura_id' => $request->asignatura_id,
            'curso_id' => $request->curso_id,
            'aula_id' => $request->aula_id,
            'franja_id' => $request->franja_id,
            'dia_semana' => $request->dia_semana
        ]);

        return response()->json($horario->load(['user', 'asignatura', 'curso', 'aula', 'franjaHoraria']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $horario = Horario::with([
            'user',
            'asignatura',
            'curso',
            'aula',
            'franjaHoraria'
        ])->findOrFail($id);

        if ($request->user()->rol === 'profesor' && $horario->usuario_id !== $request->user()->id) {
            abort(403, 'No autorizado');
        }

        return $horario;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $horario = Horario::findOrFail($id);

        if ($request->user()->rol === 'profesor' && $horario->usuario_id !== $request->user()->id) {
            abort(403, 'No autorizado');
        }

        $usuarioId = $request->user()->rol === 'admin'
            ? $request->input('usuario_id')
            : $horario->usuario_id;

        if ($request->user()->rol === 'profesor') {
            $request->merge(['usuario_id' => $usuarioId]);
        }

        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'curso_id' => 'required|exists:cursos,id',
            'aula_id' => 'required|exists:aulas,id',
            'franja_id' => 'required|exists:franjas_horarias,id',
            'dia_semana' => 'required|string'
        ]);

        $horario->update([
            'usuario_id' => $usuarioId,
            'asignatura_id' => $request->asignatura_id,
            'curso_id' => $request->curso_id,
            'aula_id' => $request->aula_id,
            'franja_id' => $request->franja_id,
            'dia_semana' => $request->dia_semana
        ]);

        return response()->json($horario->fresh(['user', 'asignatura', 'curso', 'aula', 'franjaHoraria']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $horario = Horario::findOrFail($id);

        if ($request->user()->rol === 'profesor' && $horario->usuario_id !== $request->user()->id) {
            abort(403, 'No autorizado');
        }

        $horario->delete();
        return response()->json(null, 204);
    }
}
