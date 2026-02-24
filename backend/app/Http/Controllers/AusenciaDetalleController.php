<?php

namespace App\Http\Controllers;

use App\Models\AusenciaDetalle;
use Illuminate\Http\Request;

class AusenciaDetalleController extends Controller
{
    private function puedeGestionar(Request $request, AusenciaDetalle $detalle): bool
    {
        if ($request->user()->rol === 'admin') {
            return true;
        }
        return $detalle->ausencia->usuario_id === $request->user()->id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AusenciaDetalle::with(['ausencia.user', 'horario']);

        if ($request->user()->rol === 'profesor') {
            $query->whereHas('ausencia', fn ($q) => $q->where('usuario_id', $request->user()->id));
        }

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ausencia_id' => 'required|exists:ausencias,id',
            'horario_id' => 'required|exists:horarios,id',
            'fecha' => 'required|date',
            'tareas' => 'nullable|string'
        ]);

        $ausencia = \App\Models\Ausencia::findOrFail($request->ausencia_id);
        if ($request->user()->rol === 'profesor' && $ausencia->usuario_id !== $request->user()->id) {
            abort(403, 'No autorizado');
        }

        $ausenciaDetalle = AusenciaDetalle::create([
            'ausencia_id' => $request->ausencia_id,
            'horario_id' => $request->horario_id,
            'fecha' => $request->fecha,
            'tareas' => $request->tareas
        ]);

        return response()->json($ausenciaDetalle->load(['ausencia', 'horario']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $detalle = AusenciaDetalle::with(['ausencia', 'horario'])->findOrFail($id);

        if (!$this->puedeGestionar($request, $detalle)) {
            abort(403, 'No autorizado');
        }

        return $detalle;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ausenciaDetalle = AusenciaDetalle::with('ausencia')->findOrFail($id);

        if (!$this->puedeGestionar($request, $ausenciaDetalle)) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'ausencia_id' => 'required|exists:ausencias,id',
            'horario_id' => 'required|exists:horarios,id',
            'fecha' => 'required|date',
            'tareas' => 'nullable|string'
        ]);

        $ausencia = \App\Models\Ausencia::findOrFail($request->ausencia_id);
        if ($request->user()->rol === 'profesor' && $ausencia->usuario_id !== $request->user()->id) {
            abort(403, 'No autorizado');
        }

        $ausenciaDetalle->update([
            'ausencia_id' => $request->ausencia_id,
            'horario_id' => $request->horario_id,
            'fecha' => $request->fecha,
            'tareas' => $request->tareas,
        ]);

        return response()->json($ausenciaDetalle->fresh(['ausencia', 'horario']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $ausenciaDetalle = AusenciaDetalle::with('ausencia')->findOrFail($id);

        if (!$this->puedeGestionar($request, $ausenciaDetalle)) {
            abort(403, 'No autorizado');
        }

        $ausenciaDetalle->delete();
        return response()->json(null, 204);
    }
}
