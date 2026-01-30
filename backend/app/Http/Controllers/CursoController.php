<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Curso::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $curso = Curso::create([
            'nombre' =>$request->nombre
        ]);

        return response()->json($curso);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Curso::findOrFail($id);
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

        $curso = Curso::findOrFail($id);
        $curso->update([
            'nombre'=>$request->nombre
        ]);

        return response()->json($curso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Curso::destroy($id);

        return response()->json(null, 204);
    }
}
