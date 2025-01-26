<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campus = Campus::all();
        return response()->json($campus);
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
            'nombre' => 'required|string|max:255',
            'deshabilitado' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $campus = Campus::create($request->all());
        return response()->json($campus, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campus $campus)
    {
        return response()->json($campus);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campus $campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campus $campus)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'deshabilitado' => ['required', Rule::in([0, 1, '0', '1'])], // <-- Validación más robusta
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $campus->nombre = $request->nombre;
        $campus->deshabilitado = (bool) $request->deshabilitado; // Conversión explícita a booleano
        $campus->save();

        return response()->json($campus, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function disable(Campus $campus)
    {
        $campus->deshabilitado = 1; // Cambia el valor a 1 para deshabilitar
        $campus->save();
        return response()->json(['message' => 'Campus deshabilitado correctamente'], 200);
    }

    public function enable($id)
    {
        $user = Campus::findOrFail($id);
        $user->deshabilitado = 0;
        $user->save();

        return response()->json(['message' => 'Campus enabled successfully'], 200);
    }
}
