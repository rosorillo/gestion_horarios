<?php

namespace App\Http\Controllers;

use App\Models\FranjaHoraria;
use Illuminate\Http\Request;

class FranjaHorariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return FranjaHoraria::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'hora_inicio' => 'required',
            'hora_fin' => 'required',  
            'orden' => 'required|integer' 
        ]);

        $franjaHoraria = FranjaHoraria::create([
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'orden' => $request->orden
        ]);

        return response()->json($franjaHoraria);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return FranjaHoraria::findOrFail($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $request->validate([
            'hora_inicio' => 'required',
            'hora_fin' => 'required',  
            'orden' => 'required|integer' 
        ]);

        $franjaHoraria = FranjaHoraria::findOrFail($id);
        $franjaHoraria->update([
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'orden' => $request->orden
        ]);

        return response()->json($franjaHoraria);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        FranjaHoraria::destroy($id);

        return response()->json(null, 204);
    }
}
