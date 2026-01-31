<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use Illuminate\Http\Request;

class AusenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return Ausencia::with([
            'user'
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
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'motivo' => 'required|string'
        ]);

        $ausencia = Ausencia::create([
            'usuario_id' => $request->usuario_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'motivo' => $request->motivo,
        ]);

        return response()->json($ausencia);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Ausencia::with([
            'user'
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
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'motivo' => 'required|string'
        ]);

        $ausencia = Ausencia::findOrFail($id);
        $ausencia->update([
            'usuario_id' => $request->usuario_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'motivo' => $request->motivo,
        ]);

        return response()->json($ausencia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $ausencia = Ausencia::destroy($id);
        return response()->json(null, 204);
    }
}
