<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mantenimientos = Mantenimiento::with('usuario', 'maquina')->get();
        return response()->json(['mantenimientos' => $mantenimientos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'duracion' => 'required|integer',
                'fecha_inicio' => 'required|date',
                'proxima_fecha' => 'required|date',
                'descripcion' => 'required|string',
                'periodo' => 'required|string',
                'id_maquina' => 'required|exists:maquinas,id'
            ]);

            // Crear el mantenimiento, incluyendo explícitamente 'fecha_inicio' y 'id_usuario'
            $mantenimiento = Mantenimiento::create([
                'duracion' => $validatedData['duracion'],
                'fecha_inicio' => $validatedData['fecha_inicio'],
                'proxima_fecha' =>  $validatedData['proxima_fecha'],
                'descripcion' => $validatedData['descripcion'],
                'periodo' => $validatedData['periodo'],
                'id_maquina' => $validatedData['id_maquina'],
                'id_usuario' => auth()->user()->id, // Añadir el ID del usuario autenticado
            ]);

            return response()->json(['message' => 'Mantenimiento creado correctamente', 'mantenimiento' => $mantenimiento], 201);

        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['errors' => $validationException->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el mantenimiento: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        try {
            $mantenimiento = DB::table('mantenimientos')
                ->join('maquinas', 'mantenimientos.id_maquina', '=', 'maquinas.id')
                ->join('users', 'mantenimientos.id_usuario', '=', 'users.id')
                ->where('mantenimientos.id', $id)
                ->select('mantenimientos.*', 'maquinas.nombre as nombre_maquina', 'users.name as nombre_usuario')
                ->first();

            if (!$mantenimiento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mantenimiento no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detalles del mantenimiento obtenidos exitosamente',
                'data' => $mantenimiento
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un problema al obtener los detalles del mantenimiento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mantenimiento $mantenimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $validator = Validator::make($request->all(), [
            'duracion' => 'integer',
            'fecha_inicio' => 'date',
            'proxima_fecha' => 'date',
            'descripcion' => 'string',
            'periodo' => 'string',
            'id_maquina' => 'exists:maquinas,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        try {
            $mantenimiento->update($request->all());
            return response()->json($mantenimiento, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el mantenimiento.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mantenimiento $mantenimiento)
    {
        try {
            $mantenimiento->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el mantenimiento.', 'error' => $e->getMessage()], 500);
        }
    }
}
