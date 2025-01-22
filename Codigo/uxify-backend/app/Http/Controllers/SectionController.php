<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secciones = Section::all();
        return response()->json($secciones);

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
            'n_seccion' => 'required|integer',
            'id_campus' => 'required|exists:campuses,id',
            'deshabilitado' => ['required', Rule::in([0, 1])],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $seccion = Section::create([
            'nombre' => $request->input('nombre'),
            'n_seccion' => $request->input('n_seccion'),
            'id_campus' => $request->input('id_campus'),
            'deshabilitado' => $request->input('deshabilitado'),
        ]);

        return response()->json($seccion, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Section $seccion)
    {
        return response()->json($seccion);
    }
    public function getSectionsWithCampus(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de resultados por página (por defecto 10)
        $secciones = Section::with('campus')->paginate($perPage);

        return response()->json($secciones);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $seccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $seccion)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'n_seccion' => 'required|integer',
            'id_campus' => 'required|exists:campuses,id',
            'deshabilitado' => ['required', Rule::in([0, 1])],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $seccion->update($request->all());
        return response()->json($seccion, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $seccion)
    {
        //
    }

    public function disable(Section $seccion)
    {
        $seccion->deshabilitado = !$seccion->deshabilitado; // Alterna el estado
        $seccion->save();

        $message = $seccion->deshabilitado ? 'Sección deshabilitada correctamente' : 'Sección habilitada correctamente';
        return response()->json(['message' => $message], 200);
    }

    public function getSectionsByCampus($campus){
        $seccionesPorCampus = Section::where('id_campus', $campus)->get();

        return response()->json(['sections' => $seccionesPorCampus]);
    }
}
