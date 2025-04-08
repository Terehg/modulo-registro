<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $turnos = Turno::all();
        return response()->json([
            'success' => true,
            'data' => $turnos
        ]);
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|unique:turnos|max:255',
        ]);

        $turnos = Turno::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Turno creado correctamente',
            'data' => $turnos
        ], Response::HTTP_CREATED);
    }
 /**
     * Display the specified resource.
     */
    public  function show($id)
    {
        $turnos = Turno::find($id);

        if(!$turnos){
            return response()->json([
                'success' => false,
                'message' => 'Turno no encontrado'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data'=> $turnos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $turno = Turno::find($id);

        if (!$turno) {
            return response()->json([
                'success' => false,
                'message' => 'Turno no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'nombre' => 'required|max:255|unique:turnos,nombre,' . $id,
        ]);

        $turno->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Turno actualizado correctamente',
            'data' => $turno
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $turno = Turno::find($id);

        if (!$turno) {
            return response()->json([
                'success' => false,
                'message' => 'Turno no encontrado'
            ], 404);
        }

        $turno->delete();

        return response()->json([
            'success' => true,
            'message' => 'Turno eliminado correctamente'
        ]);
    }

}