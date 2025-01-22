<?php

namespace App\Http\Controllers;

use App\Models\IncidenciaTecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class IncidenciaTecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'id_incidencia' => 'required|integer',
            'id_tecnico' => 'required|integer',
            'fecha_inicio' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            $incidencia = new IncidenciaTecnico();
            $incidencia->id_incidencia = $request->id_incidencia;
            $incidencia->id_tecnico = $request->id_tecnico;
            $incidencia->fecha_inicio = $request->fecha_inicio;
            $incidencia->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error storing IncidenciaTecnico: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(IncidenciaTecnico $incidenciaTecnico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncidenciaTecnico $incidenciaTecnico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha_fin' => 'required|date',
            'comentario' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            $incidencia = IncidenciaTecnico::find($id);

            if (!$incidencia) {
                return response()->json(['success' => false, 'message' => 'IncidenciaTecnico not found'], 404);
            }

            $incidencia->fecha_fin = $request->fecha_fin;
            $incidencia->comentario = $request->comentario;
            $incidencia->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating IncidenciaTecnico: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidenciaTecnico $incidenciaTecnico)
    {
        //
    }

    public function getLatestIncidenciaTecnico(Request $request)
    {
        $idIncidencia = $request->input('id_incidencia');
        $idTecnico = $request->input('id_tecnico');

        $incidenciaTecnico = IncidenciaTecnico::where('id_incidencia', $idIncidencia)
            ->where('id_tecnico', $idTecnico)
            ->orderBy('fecha_inicio', 'desc')
            ->first();

        if ($incidenciaTecnico) {
            return response()->json($incidenciaTecnico);
        } else {
            return response()->json(['message' => 'No se encontró el registro'], 404);
        }
    }
}
