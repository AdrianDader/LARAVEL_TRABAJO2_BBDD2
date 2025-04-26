<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    public function register(Request $request)
    {
        // Validar la petición
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hasheamos la password
            'role' => 'user', // 👈 Siempre creamos como 'user'
        ]);

        // (Opcional) Crear un token para autenticar después
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolver respuesta
        return response()->json([
            'message' => 'Usuario creado correctamente.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }














}
