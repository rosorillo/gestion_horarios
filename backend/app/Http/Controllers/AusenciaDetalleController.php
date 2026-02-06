<?php

namespace App\Http\Controllers;

use App\Models\AusenciaDetalle;
use Illuminate\Http\Request;

class AusenciaDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return AusenciaDetalle::with([
            'ausencia',
            'horario'
        ])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'ausencia_id' => 'required|exists:ausencia,id',
            'horario_id' => 'required|exists:horario,id',
            'fecha' => 'required|date',
            'tareas' => 'nullable|string'
        ]);

        $ausenciaDetalle = AusenciaDetalle::create([
            'ausencia_id' => $request->ausencia_id,
            'horario_id' => $request->horario_id,
            'fecha' => $request->fecha,
            'tareas' => $request->tareas
        ]);

        return response()->json($ausenciaDetalle);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return AusenciaDetalle::with([
            'ausencia',
            'horario'
        ])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'ausencia_id' => 'required|exists:ausencia,id',
            'horario_id' => 'required|exists:horario,id',
            'fecha' => 'required|date',
            'tareas' => 'nullable|string'
        ]);

        $ausenciaDetalle = AusenciaDetalle::findOrFail($id);
        $ausenciaDetalle->update([
            'ausencia_id' => $request->ausencia_id,
            'horario_id' => $request->horario_id,
            'fecha' => $request->fecha,
            'tareas' => $request->tareas,

        ]);

        return response()->json($ausenciaDetalle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $ausenciaDetalle = AusenciaDetalle::destroy($id);
        return response()->json(null, 204);
    }
}
