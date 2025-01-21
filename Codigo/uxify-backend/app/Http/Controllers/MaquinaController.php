<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function index()
//    {
//        $maquinas = Maquina::with('section.campus')->get();
//        return response()->json($maquinas);
//    }

    public function index()
    {
        $maquinas = Maquina::with('section.campus')->paginate(8); // Adjust the number of items per page as needed
        return response()->json($maquinas);
    }
    public function getMaquinasTD(){
        $maquinasTodas = Maquina::all();
        return response()->json($maquinasTodas);
    }
    public function estdoMaquinaPorId(Request $request, $id)
    {
        try {
            $maquina = Maquina::findOrFail($id);

            // Devolver el estado directamente
            return response()->json(['estado' => $maquina->estado], 200);


        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el estado de la máquina: ' . $e->getMessage()], 500);
        }
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
            $request->validate([
                'nombre' => 'required|string|max:255',
                'codigo' => 'required|string|max:255',
                'prioridad' => 'required|integer',
                'estado' => 'required|integer',
                'id_section' => 'required|exists:sections,id',
                'deshabilitado' => 'boolean'
            ]);

            $maquina = new Maquina();
            $maquina->nombre = $request->nombre;
            $maquina->codigo = $request->codigo;
            $maquina->prioridad = $request->prioridad;
            $maquina->estado = $request->estado;
            $maquina->id_section = $request->id_section;
            $maquina->deshabilitado = $request->deshabilitado ?? 0;
            $maquina->save();

            return response()->json(['message' => 'Maquina created successfully', 'maquina' => $maquina], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating Maquina: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Maquina $maquina)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maquina $maquina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maquina $maquina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maquina $maquina)
    {
        //
    }

    public function countMaquinas(){
        $maquinasTotal = Maquina::count();
        $maquinas1 = Maquina::where('prioridad', 1)->count();
        $maquinas2 = Maquina::where('prioridad', 2)->count();
        $maquinas3 = Maquina::where('prioridad', 3)->count();

        return response()
            ->json([
                'total' => $maquinasTotal,
                'prioridad1' => $maquinas1,
                'prioridad2' => $maquinas2,
                'prioridad3' => $maquinas3,
            ]);
    }

    public function enable($id)
    {
        $machine = Maquina::findOrFail($id);
        $machine->deshabilitado = 0;
        $machine->save();

        return response()->json(['message' => 'Machine enabled successfully'], 200);
    }

    public function disable($id)
    {
        $machine = Maquina::findOrFail($id);
        $machine->deshabilitado = 1;
        $machine->save();

        return response()->json(['message' => 'Machine disabled successfully'], 200);
    }
}
