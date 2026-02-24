<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Aula::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre'=>'required|string|max:255'
        ]);

        $aula = Aula::create([
            'nombre'=> $request->nombre
        ]);

        return response()->json($aula);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Aula::findOrFail($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $aula = Aula::findOrFail($id);
        $aula->update([
            'nombre' => $request->nombre
        ]);

        return response()->json($aula);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Aula::destroy($id);

        return response()->json(null, 204);
    }
}
