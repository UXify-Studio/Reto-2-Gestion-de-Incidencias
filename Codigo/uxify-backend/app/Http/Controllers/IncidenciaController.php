<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Mantenimiento;
use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\b;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prioridad = $request->query('priority', -1);

        $query = DB::table('incidencias as i')
            ->join('maquinas as m', 'i.id_maquina', '=', 'm.id')
            ->join('categorias as c', 'i.id_categoria', '=', 'c.id')
            ->select('i.*', 'm.prioridad', 'm.estado as gravedad_incidencia', 'm.nombre as nombre_maquina', 'c.nombre as categoria')
            ->orderBy('m.estado', 'desc')
            ->orderBy('m.prioridad', 'asc')
            ->orderBy('i.fecha_creacion', 'desc');

        if ($prioridad < 0) {
            $query->where('i.resuelta', 0);

        } else {
            switch ((int)$prioridad) {
                case 0:
                    $query->where('i.resuelta', 1);
                    break;
                case 1:
                    $query->where('m.prioridad', 1);
                    break;
                case 2:
                    $query->where('m.prioridad', 2);
                    break;
                case 3:
                    $query->where('m.prioridad', 3);
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'No se encontraron incidencias.'
                    ], 404);
            }
        }

        //$result = $query->get();
        $result = $query->paginate(12);

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

    public function index2()
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
                'id_categoria' => 'required|integer',
                'id_maquina' => 'required|integer',
                'estado' => 'required|integer', // Validar el estado de la incidencia
            ]);

            // Crear la incidencia
            $incidencia = Incidencia::create([
                'titulo' => $validatedData['titulo'],
                'descripcion' => $validatedData['descripcion'],
                'id_categoria' => $validatedData['id_categoria'],
                'id_maquina' => $validatedData['id_maquina'],
                'id_usuario' => auth()->user()->id, // Asignar el ID del usuario autenticado
                'estado' => $validatedData['estado'] // Asignar el estado de la incidencia
            ]);

            // Actualizar el estado de la máquina
            $maquina = Maquina::findOrFail($validatedData['id_maquina']);
            $maquina->estado = $validatedData['estado'];
            $maquina->save();

            return response()->json(['message' => 'Incidencia creada correctamente', 'incidencia' => $incidencia], 201);

        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['errors' => $validationException->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la incidencia: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = DB::table('incidencias as i')
            ->join('maquinas as m', 'i.id_maquina', '=', 'm.id')
            ->join('categorias as c', 'i.id_categoria', '=', 'c.id')
            ->join('users as u', 'i.id_usuario', '=', 'u.id')
            ->select('i.*', 'm.nombre as nombre_maquina', 'c.nombre as nombre_categoria', 'u.name as nombre_usuario')
            ->where('i.id', $id)
            ->first();

        if ($result) {
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontró la incidencia.'
        ], 404);
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

    public function countIncidenciasPorPrioridad()
    {

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

            switch ($i) {
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

        if ($result > 0) {
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

    public function getIncidenciasByCampus($campus)
    {
        $result = DB::table('incidencias as inc')
            ->join('categorias as cat', 'inc.id_categoria', '=', 'cat.id')
            ->join('maquinas as maq', 'inc.id_maquina', '=', 'maq.id')
            ->join('sections as sect', 'maq.id_section', '=', 'sect.id')
            ->join('campuses as camp', 'sect.id_campus', '=', 'camp.id')
            ->select('inc.*', 'maq.prioridad', 'maq.estado as gravedad_incidencia', 'maq.nombre as nombre_maquina', 'cat.nombre as categoria')
            ->where('resuelta', 0)
            ->where('camp.id', $campus)
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

    public function getIncidenciasBySection($section)
    {
        $result = DB::table('incidencias as inc')
            ->join('categorias as cat', 'inc.id_categoria', '=', 'cat.id')
            ->join('maquinas as maq', 'inc.id_maquina', '=', 'maq.id')
            ->join('sections as sect', 'maq.id_section', '=', 'sect.id')
            ->join('campuses as camp', 'sect.id_campus', '=', 'camp.id')
            ->select('inc.*', 'maq.prioridad', 'maq.estado as gravedad_incidencia', 'maq.nombre as nombre_maquina', 'cat.nombre as categoria')
            ->where('resuelta', 0)
            ->where('sect.id', $section)
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

    public function marcarIncidenciaComoResuelta($id_incidencia)
    {
        try {
            $tecnicosTrabajando = DB::table('incidencia_tecnicos')
                ->where('id_incidencia', $id_incidencia)
                ->whereNotNull('fecha_inicio')
                ->whereNull('fecha_fin')
                ->exists();

            if ($tecnicosTrabajando) {
                return response()->json(['success' => false, 'message' => 'No se puede marcar la incidencia como resuelta porque hay técnicos trabajando en ella.'], 400);
            }

            $incidencia = Incidencia::findOrFail($id_incidencia);
            $incidencia->resuelta = 1;
            $incidencia->save();

            return response()->json(['success' => true, 'message' => 'Incidencia marcada como resuelta']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al marcar la incidencia como resuelta: ' . $e->getMessage()], 500);
        }
    }

    public function actualizarComentario(Request $request, $id_incidencia)
    {
        $validatedData = $request->validate([
            'comentario' => 'required|string',
        ]);

        try {
            $incidencia = Incidencia::findOrFail($id_incidencia);
            $incidencia->comentario = $validatedData['comentario'];
            $incidencia->save();

            return response()->json(['success' => true, 'message' => 'Comentario actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el comentario: ' . $e->getMessage()], 500);
        }
    }

    public function obtenerComentario($id_incidencia)
    {
        try {
            $incidencia = Incidencia::findOrFail($id_incidencia);
            return response()->json(['success' => true, 'comentario' => $incidencia->comentario]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al obtener el comentario: ' . $e->getMessage()], 500);
        }
    }
}
