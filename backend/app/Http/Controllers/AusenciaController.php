<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use App\Models\User;
use App\Notifications\AusenciaRegistradaNotification;
use Illuminate\Http\Request;

class AusenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ausencia::with(['user']);

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
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'motivo' => 'required|string'
        ]);

        $ausencia = Ausencia::create([
            'usuario_id' => $usuarioId,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'motivo' => $request->motivo,
        ]);

        $ausencia->load('user');

        $admins = User::where('rol', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AusenciaRegistradaNotification($ausencia));
        }

        return response()->json($ausencia);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $ausencia = Ausencia::with(['user'])->findOrFail($id);

        if ($request->user()->rol === 'profesor' && $ausencia->usuario_id !== $request->user()->id) {
            abort(403, 'No autorizado');
        }

        return $ausencia;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ausencia = Ausencia::findOrFail($id);

        if ($request->user()->rol === 'profesor' && $ausencia->usuario_id !== $request->user()->id) {
            abort(403, 'No autorizado');
        }

        $usuarioId = $request->user()->rol === 'admin'
            ? $request->input('usuario_id')
            : $ausencia->usuario_id;

        if ($request->user()->rol === 'profesor') {
            $request->merge(['usuario_id' => $usuarioId]);
        }

        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'motivo' => 'required|string'
        ]);

        $ausencia->update([
            'usuario_id' => $usuarioId,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'motivo' => $request->motivo,
        ]);

        return response()->json($ausencia->fresh('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $ausencia = Ausencia::findOrFail($id);

        if ($request->user()->rol === 'profesor' && $ausencia->usuario_id !== $request->user()->id) {
            abort(403, 'No autorizado');
        }

        $ausencia->delete();
        return response()->json(null, 204);
    }
}
