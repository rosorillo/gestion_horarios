<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function login(Request $request) {

   $request->validate([
    'email' => 'required|string',
    'password' => 'required'
   ]);

   $user = User::where('email', $request->email)->first();

   if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
   }

   $token = $user->createToken('auth_token')->plainTextToken;

   return response()->json([
    'user' => $user,
    'token' => $token
   ]);
   
   }

   public function logout(Request $request) {
    $request->user()->currentAccesToken()->delete();

    return response()->json([
        'message' => 'Sesión cerrada'
    ]);
   }

   public function me(Request $request) {
    return response()->json($request->user());
   }
}
