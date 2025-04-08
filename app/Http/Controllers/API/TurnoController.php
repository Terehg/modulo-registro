<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TurnoController extends Controller
{
    // Funcion para mostrar los datos
    public function index()
    {
        $turnos = Turno::all();
        return response()->json([
            'success' => true,
            'data' => $turnos
        ]);

    }

    // Funcion para guardar los datos
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

    // Funcion para mostrar los datos por id
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

    // Funcion para editar los datos
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

    // Funcion para eliminar los datos
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
