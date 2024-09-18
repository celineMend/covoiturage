<?php

namespace App\Http\Controllers;
use App\Models\Trajet;
use Illuminate\Http\Request;

class TrajetController extends Controller
{
    public function index()
    {
        $trajets = Trajet::all();
        return response()->json($trajets);
    }

    public function show($id)
    {
        $trajet = Trajet::find($id);
        if (!$trajet) {
            return response()->json(['message' => 'Trajet not found'], 404);
        }
        return response()->json($trajet);
    }

    public function store(Request $request)
    {
        $request->validate([
            'conducteur_id' => 'required|exists:conducteurs,id',
            'point_depart' => 'required|string',
            'point_arrivee' => 'required|string',
            'date_heure_depart' => 'required|date',
            'statut' => 'required|in:en cours,terminer,annuler,confirmer',
            'vehicule_id' => 'required|exists:vehicules,id',
            'prix' => 'required|numeric',
        ]);

        $trajet = Trajet::create($request->all());
        return response()->json($trajet, 201);
    }

    public function update(Request $request, $id)
    {
        $trajet = Trajet::find($id);
        if (!$trajet) {
            return response()->json(['message' => 'Trajet not found'], 404);
        }

        $request->validate([
            'conducteur_id' => 'sometimes|required|exists:conducteurs,id',
            'point_depart' => 'sometimes|required|string',
            'point_arrivee' => 'sometimes|required|string',
            'date_heure_depart' => 'sometimes|required|date',
            'statut' => 'sometimes|required|in:en cours,terminer,annuler,confirmer',
            'vehicule_id' => 'sometimes|required|exists:vehicules,id',
            'prix' => 'sometimes|required|numeric',
        ]);

        $trajet->update($request->all());
        return response()->json($trajet);
    }

    public function destroy($id)
    {
        $trajet = Trajet::find($id);
        if (!$trajet) {
            return response()->json(['message' => 'Trajet not found'], 404);
        }
        $trajet->delete();
        return response()->json(['message' => 'Trajet deleted successfully']);
    }
}
