<?php

namespace App\Http\Controllers;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::all();
        return response()->json($vehicules);
    }

    public function show($id)
    {
        $vehicule = Vehicule::find($id);
        if (!$vehicule) {
            return response()->json(['message' => 'Vehicule not found'], 404);
        }
        return response()->json($vehicule);
    }

    public function store(Request $request)
    {
        $request->validate([
            'conducteur_id' => 'required|exists:conducteurs,id',
            'marque' => 'required|string',
            'modele' => 'required|string',
            'immatriculation' => 'required|string',
            'nombre_place' => 'required|integer',
            'Assurance_vehicule' => 'required|string',
            'photo' => 'required|string',
        ]);

        $vehicule = Vehicule::create($request->all());
        return response()->json($vehicule, 201);
    }

    public function update(Request $request, $id)
    {
        $vehicule = Vehicule::find($id);
        if (!$vehicule) {
            return response()->json(['message' => 'Vehicule not found'], 404);
        }

        $request->validate([
            'conducteur_id' => 'sometimes|required|exists:conducteurs,id',
            'marque' => 'sometimes|required|string',
            'modele' => 'sometimes|required|string',
            'immatriculation' => 'sometimes|required|string',
            'nombre_place' => 'sometimes|required|integer',
            'Assurance_vehicule' => 'sometimes|required|string',
            'photo' => 'sometimes|required|string',
        ]);

        $vehicule->update($request->all());
        return response()->json($vehicule);
    }

    public function destroy($id)
    {
        $vehicule = Vehicule::find($id);
        if (!$vehicule) {
            return response()->json(['message' => 'Vehicule not found'], 404);
        }
        $vehicule->delete();
        return response()->json(['message' => 'Vehicule deleted successfully']);
    }
}
