<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Mantenimiento::all();
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
        $validator = Validator::make($request->all(), [
            'duracion' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'proxima_fecha' => 'required|date',
            'descripcion' => 'required|string',
            'periodo' => 'required|string',
            'id_maquina' => 'required|exists:maquinas,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }
        try{
            $mantenimiento = Mantenimiento::create($request->all());

            return response()->json($mantenimiento, 201);
        } catch (\Exception $e){
            return response()->json(['message' => 'Error al crear el mantenimiento.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mantenimiento $mantenimiento)
    {
        return $mantenimiento;
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
