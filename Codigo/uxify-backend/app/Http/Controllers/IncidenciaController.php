<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
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
        //
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
