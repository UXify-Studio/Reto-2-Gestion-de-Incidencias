<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoTecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MantenimientoTecnicoController extends Controller
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
            'id_mantenimiento' => 'required|integer',
            'id_tecnico' => 'required|integer',
            'fecha_inicio' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            $mantemiento = new MantenimientoTecnico();
            $mantemiento->id_mantenimiento = $request->id_mantenimiento;
            $mantemiento->id_tecnico = $request->id_tecnico;
            $mantemiento->fecha_inicio = $request->fecha_inicio;
            $mantemiento->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error storing MantenimientoaTecnico: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MantenimientoTecnico $mantenimientoTecnico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MantenimientoTecnico $mantenimientoTecnico)
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
            $mantenimiento = MantenimientoTecnico::find($id);

            if (!$mantenimiento) {
                return response()->json(['success' => false, 'message' => 'MantenimientoTecnico not found'], 404);
            }

            $mantenimiento->fecha_fin = $request->fecha_fin;
            $mantenimiento->comentario = $request->comentario;
            $mantenimiento->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating MantenimientoTecnico: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MantenimientoTecnico $mantenimientoTecnico)
    {
        //
    }

    public function getLatestMantenimientoTecnico(Request $request)
    {
        $idMantenimiento = $request->input('id_mantenimiento');
        $idTecnico = $request->input('id_tecnico');

        $mantenimientoTecnico = MantenimientoTecnico::where('id_mantenimiento', $idMantenimiento)
            ->where('id_tecnico', $idTecnico)
            ->orderBy('fecha_inicio', 'desc')
            ->first();

        if ($mantenimientoTecnico) {
            return response()->json($mantenimientoTecnico);
        } else {
            return response()->json(['message' => 'No se encontró el registro'], 404);
        }
    }

    public function calcularTiempoTrabajado($id_mantenimiento)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated']);
        }

        $id_tecnico = $user->id;

        $mantenimientosTecnico = MantenimientoTecnico::where('id_mantenimiento', $id_mantenimiento)
            ->where('id_tecnico', $id_tecnico)
            ->get();

        $totalTiempo = 0;


        foreach ($mantenimientosTecnico as $mantenimiento) {
            if ($mantenimiento->fecha_inicio && $mantenimiento->fecha_fin) {
                $fechaInicio = Carbon::parse($mantenimiento->fecha_inicio);
                $fechaFin = Carbon::parse($mantenimiento->fecha_fin);

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
