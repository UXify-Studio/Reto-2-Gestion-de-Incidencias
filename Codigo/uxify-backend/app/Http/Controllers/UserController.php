<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::with('rol')->get();
        return response()->json($users);
    }

    public function store(Request $request) {
        // Validar los datos del usuario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'id_rol' => 'required|integer|exists:roles,id',
        ]);

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'id_rol' => $validatedData['id_rol'],
        ]);

        // Retornar la respuesta en formato JSON
        return response()->json($user, 201);
    }

    public function login(Request $request) {
        // Validar las credenciales del usuario
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Generar un token de autenticación
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retornar la respuesta en formato JSON con el token
        return response()->json(['token' => $token, 'user' => $user], 200);
    }
}
