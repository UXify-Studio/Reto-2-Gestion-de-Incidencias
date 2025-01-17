<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
//    public function index() {
//        $users = User::with('rol')->get();
//        return response()->json($users);
//    }

//    public function index() {
//        $users = User::with('rol')->paginate(12);
//        return response()->json($users);
//    }

    public function index(Request $request) {
        // Obtener el filtro de rol (si existe)
        $role = $request->query('role');

        // Comenzar la consulta para obtener usuarios con su rol
        $query = User::with('rol');

        // Filtrar por rol si se pasa el parámetro 'role'
        if ($role) {
            $query->whereHas('rol', function($q) use ($role) {
                $q->where('nombre', $role); // Ajusta esto si estás filtrando por id en lugar de nombre
            });
        }

        // Paginación de usuarios
        $users = $query->paginate(7);

        // Retornar los usuarios paginados en formato JSON
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

    public function countUsers() {
        $usersTotal = User::count();
        $usersAdmin = User::where('id_rol', 1)->count();
        $usersTecnico = User::where('id_rol', 2)->count();
        $usersOperario = User::where('id_rol', 3)->count();

        return response()
            ->json([
                'total' => $usersTotal,
                'admin' => $usersAdmin,
                'tecnico' => $usersTecnico,
                'operario' => $usersOperario,
                ]);
    }
}
