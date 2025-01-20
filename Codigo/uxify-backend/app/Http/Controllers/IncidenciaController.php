<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidencias = Incidencia::all();
        return response()->json($incidencias);
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
                'titulo' => 'required|string',
                'descripcion' => 'required|string',
                'categoria' => 'required|integer', // O el tipo de dato que corresponda
                'maquina' => 'required|integer',
                'estado' => 'required|integer'
            ]);

            $incidencia = Incidencia::create($validatedData);

            // Actualizar el estado de la máquina
            $maquina = Maquina::findOrFail($request->maquina);
            $maquina->estado = $request->estado;
            $maquina->save();



            return response()->json(['message' => 'Incidencia creada correctamente', 'incidencia' => $incidencia], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la incidencia: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incidencia $incidencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia)
    {
        //
    }

    public function getUltimasIncidenciasPorPrioridad()
    {
        $result = DB::table('incidencias as i')
            ->join('maquinas as m', 'i.id_maquina', '=', 'm.id')
            ->join('categorias as c', 'i.id_categoria', '=', 'c.id')
            ->select('i.*', 'm.prioridad', 'm.nombre as nombre_maquina', 'c.nombre as categoria')
            ->orderBy('i.created_at', 'desc')
            ->limit(5)
            ->get();

        if ($result->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontraron incidencias.'
        ], 404);
    }
}
