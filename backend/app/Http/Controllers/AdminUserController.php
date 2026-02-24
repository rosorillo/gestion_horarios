<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::select(
            'id',
            'nombre',
            'email',
            'rol',
            'foto'
        )->with('ausencias')->get();

        return $usuarios->map(function ($user) {
            $diasFalta = $user->ausencias
                ->sum(fn ($a) => Carbon::parse($a->fecha_inicio)->startOfDay()
                    ->diffInDays(Carbon::parse($a->fecha_fin)->startOfDay()) + 1);
            $userArray = $user->only(['id', 'nombre', 'email', 'rol', 'foto']);
            $userArray['dias_falta'] = $diasFalta;
            return $userArray;
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:4',
            'rol' => 'required|in:admin,profesor',
            'foto' => 'nullable|string'
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'foto' => $request->foto
        ]);

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::select(
            'id',
            'nombre',
            'email',
            'rol',
            'foto'
        )->findOrFail($id);

        $diasFalta = $user->ausencias()
            ->get()
            ->sum(fn ($a) => Carbon::parse($a->fecha_inicio)->startOfDay()
                ->diffInDays(Carbon::parse($a->fecha_fin)->startOfDay()) + 1);

        $userArray = $user->toArray();
        $userArray['dias_falta'] = $diasFalta;
        return $userArray;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'rol' => 'required|in:admin,profesor',
            'foto' => 'nullable|string'
        ]);
        
        $user = User::findOrFail($id);

        $user->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'rol' => $request->rol,
            'foto' => $request->foto
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        User::destroy($id);
        return response()->json(null, 204);
    }
}
