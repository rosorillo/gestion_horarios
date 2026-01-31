<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Horario::with([
            'user',
            'asignatura',
            'curso',
            'aula',
            'franjaHoraria'

        ])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'curso_id' => 'required|exists:cursos,id',
            'aula_id' => 'required|exists:aulas,id',
            'franja_id' => 'required|exists:franjas_horarias,id',
            'dia_semana' => 'required|string'
        ]);

        $horario = Horario::create([
            'usuario_id' => $request->usuario_id,
            'asignatura_id' => $request->asignatura_id,
            'curso_id' => $request->curso_id,
            'aula_id' => $request->aula_id,
            'franja_id' => $request->franja_id,
            'dia_semana' => $request->dia_semana
        ]);

        return response()->json($horario);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         
        return Horario::with([
            'user',
            'asignatura',
            'curso',
            'aula',
            'franjaHoraria'
        ])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'curso_id' => 'required|exists:cursos,id',
            'aula_id' => 'required|exists:aulas,id',
            'franja_id' => 'required|exists:franjas_horarias,id',
            'dia_semana' => 'required|string'
        ]);

        $horario = Horario::findOrFail($id);
        $horario->update([
            'usuario_id' => $request->usuario_id,
            'asignatura_id' => $request->asignatura_id,
            'curso_id' => $request->curso_id,
            'aula_id' => $request->aula_id,
            'franja_id' => $request->franja_id,
            'dia_semana' => $request->dia_semana
        ]);

        return response()->json($horario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $horario = Horario::destroy($id);
        return response()->json(null, 204);
    }
}
