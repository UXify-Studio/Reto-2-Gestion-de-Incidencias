<?php

namespace App\Http\Controllers;

use App\Models\IncidenciaTecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

    public function calcularTiempoTrabajado($id_incidencia)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated']);
        }

        $id_tecnico = $user->id;

        $incidenciasTecnico = IncidenciaTecnico::where('id_incidencia', $id_incidencia)
            ->where('id_tecnico', $id_tecnico)
            ->get();

        $totalTiempo = 0;


        foreach ($incidenciasTecnico as $incidencia) {
            if ($incidencia->fecha_inicio && $incidencia->fecha_fin) {
                $fechaInicio = Carbon::parse($incidencia->fecha_inicio);
                $fechaFin = Carbon::parse($incidencia->fecha_fin);

                //Log::info('Fecha inicio: ' . $fechaInicio);
                //Log::info('Fecha fin: ' . $fechaFin);

                // Calcular la diferencia en segundos
                $diferencia = $fechaFin->diffInSeconds($fechaInicio, false); // El parámetro 'false' habilita diferencias negativas

                //Log::info("Diferencia calculada (sin ajustar): $diferencia");

                // Asegurarse de que la diferencia sea positiva
                $diferencia = abs($diferencia);

                //Log::info("Diferencia ajustada (positiva): $diferencia");

                $totalTiempo += $diferencia;
            }
        }





        $horas = floor($totalTiempo / 3600);
        $minutos = floor(($totalTiempo % 3600) / 60);
        $segundos = $totalTiempo % 60;

        return response()->json([
            'success' => true,
            'data' => [
                'id_tecnico' => $id_tecnico,
                'horas' => $horas,
                'minutos' => $minutos,
                'segundos' => $segundos
            ]
        ]);
    }
}
