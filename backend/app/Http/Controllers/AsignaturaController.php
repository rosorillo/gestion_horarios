<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Asignatura::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $asignatura = Asignatura::create([
            'nombre' =>$request->nombre
        ]);

        return response()->json($asignatura);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Asignatura::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nombre'=>'required|string|max:255'
        ]);

        $asignatura = Asignatura::findOrFail($id);
        $asignatura->update([
            'nombre'=>$request->nombre
        ]);

        return response()->json($asignatura);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Asignatura::destroy($id);

        return response()->json(null, 204);
    }
}
