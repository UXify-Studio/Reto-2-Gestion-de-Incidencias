<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\containsOnly;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = DB::table('incidencias as i')
            ->join('maquinas as m', 'i.id_maquina', '=', 'm.id')
            ->join('categorias as c', 'i.id_categoria', '=', 'c.id')
            ->select('i.*', 'm.prioridad', 'm.estado as gravedad_incidencia', 'm.nombre as nombre_maquina', 'c.nombre as categoria')
            ->where('resuelta', 0)
            ->orderBy('m.estado', 'desc')
            ->orderBy('m.prioridad', 'asc')
            ->orderBy('i.fecha_creacion', 'desc')
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

    public function countIncidenciasPorPrioridad(){

        $mantenimientos = Mantenimiento::count();
        $incidenciasResueltas = Incidencia::where('resuelta', 1)->count();
        $incidenciasAltas = 0;
        $incidenciasMedias = 0;
        $incidenciasBajas = 0;

        for ($i = 1; $i <= 3; $i++) {
            $result = DB::table('incidencias as inc')
                ->join('maquinas as maq', 'inc.id_maquina', '=', 'maq.id')
                ->select('*')
                ->where('maq.prioridad', $i)
                ->count();

            switch ($i){
                case 1:
                    $incidenciasAltas = $result;
                    break;
                case 2:
                    $incidenciasMedias = $result;
                    break;
                case 3:
                    $incidenciasBajas = $result;
                    break;
            }
        }

        if ($result > 0 ) {
            return response()->json([
                'success' => true,
                'data' => [
                    'alta' => $incidenciasAltas,
                    'media' => $incidenciasMedias,
                    'baja' => $incidenciasBajas,
                    'resueltas' => $incidenciasResueltas,
                    'mantenimientos' => $mantenimientos
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontraron incidencias.'
        ], 404);
    }
}
