<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Iniciar la consulta
        $query = Registro::query();
        
        // Filtrar por turno si se proporciona un turno_id
        if ($request->has('turno_id') && $request->turno_id) {
            $query->where('turno_id', $request->turno_id);
        }
        
        // Obtener los registros
        $registros = $query->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $registros
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'maquina' => 'required|max:255',
            'proyecto' => 'required|max:255',
            'turno_id' => 'required|exists:turnos,id',
        ]);

        $registro = Registro::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Registro creado correctamente',
            'data' => $registro
        ], Response::HTTP_CREATED);
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $registro = Registro::find($id);
        
        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $registro
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $registro = Registro::find($id);
        
        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
            ], 404);
        }
        
        $validated = $request->validate([
            'maquina' => 'required|max:255',
            'proyecto' => 'required|max:255',
            'turno_id' => 'required|exists:turnos,id',
        ]);
        
        $registro->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Registro actualizado correctamente',
            'data' => $registro
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $registro = Registro::find($id);
        
        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
            ], 404);
        }
        
        $registro->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Registro eliminado correctamente'
        ]);
    }
}