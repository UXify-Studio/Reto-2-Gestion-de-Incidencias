<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categorias = Categoria::all();

        return response()->json($categorias);
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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'deshabilitado' => 'required|boolean', // Asumiendo que es un boolean (0 o 1)
        ]);

        $categoria = Categoria::create([
            'nombre' => $request->nombre,
            'deshabilitado' => $request->deshabilitado,
        ]);

        return response()->json($categoria, 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        try {
            $categoria = Categoria::findOrFail($id);

            $categoria->nombre = $validatedData['nombre'];
            $categoria->save();

            return response()->json(['success' => true, 'nombre' => $categoria->nombre], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating category name: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }

    public function getIncidenciasPorPrioridad()
    {
        $result = DB::table('incidencias as i')
            ->join('maquinas as m', 'i.id_maquina', '=', 'm.id')
            ->join('categorias as c', 'i.id_categoria', '=', 'c.id')
            ->select('c.nombre as nombre', 'm.prioridad', DB::raw('COUNT(*) as cantidad_incidencias'))
            ->groupBy('c.nombre', 'm.prioridad')
            ->orderBy('c.nombre')
            ->orderBy('m.prioridad')
            ->get();

        if ($result) {
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

    public function enable($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->deshabilitado = 0;
        $categoria->save();

        return response()->json(['message' => 'Categoria enabled successfully'], 200);
    }

    public function disable($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->deshabilitado = 1;
        $categoria->save();

        return response()->json(['message' => 'Categoria disabled successfully'], 200);
    }
}
