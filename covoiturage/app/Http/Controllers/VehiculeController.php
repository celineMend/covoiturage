<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    /**
     * Afficher la liste des véhicules.
     */
    public function index()
    {
        $vehicules = Vehicule::all();

        return response()->json([
            'status' => true,
            'message' => 'Liste des véhicules récupérée avec succès',
            'data' => $vehicules
        ], 200);
    }

    /**
     * Créer un nouveau véhicule.
     */
    public function store(Request $request)
    {
        // Validation des données entrantes
        $request->validate([
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'année' => 'required|integer|min:1900|max:'.date('Y'),
            'num_immatriculation' => 'required|string|max:255|unique:vehicules,num_immatriculation',
            'capacité' => 'required|integer|min:1',
        ]);

        // Création du véhicule
        $vehicule = Vehicule::create([
            'marque' => $request->marque,
            'modele' => $request->modele,
            'année' => $request->année,
            'num_immatriculation' => $request->num_immatriculation,
            'capacité' => $request->capacité,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Véhicule créé avec succès',
            'data' => $vehicule
        ], 201);
    }

    /**
     * Afficher les détails d'un véhicule spécifique.
     */
    public function show($id)
    {
        $vehicule = Vehicule::find($id);

        if (!$vehicule) {
            return response()->json([
                'status' => false,
                'message' => 'Véhicule non trouvé',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Détails du véhicule récupérés avec succès',
            'data' => $vehicule
        ], 200);
    }

    /**
     * Mettre à jour un véhicule spécifique.
     */
    public function update(Request $request, $id)
    {
        $vehicule = Vehicule::find($id);

        if (!$vehicule) {
            return response()->json([
                'status' => false,
                'message' => 'Véhicule non trouvé',
            ], 404);
        }

        // Validation des données
        $request->validate([
            'marque' => 'sometimes|required|string|max:255',
            'modele' => 'sometimes|required|string|max:255',
            'année' => 'sometimes|required|integer|min:1900|max:'.date('Y'),
            'num_immatriculation' => 'sometimes|required|string|max:255|unique:vehicules,num_immatriculation,'.$id,
            'capacité' => 'sometimes|required|integer|min:1',
        ]);

        // Mise à jour des informations
        $vehicule->update($request->only('marque', 'modele', 'année', 'num_immatriculation', 'capacité'));

        return response()->json([
            'status' => true,
            'message' => 'Véhicule mis à jour avec succès',
            'data' => $vehicule
        ], 200);
    }

    /**
     * Supprimer un véhicule spécifique.
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::find($id);

        if (!$vehicule) {
            return response()->json([
                'status' => false,
                'message' => 'Véhicule non trouvé',
            ], 404);
        }

        $vehicule->delete();

        return response()->json([
            'status' => true,
            'message' => 'Véhicule supprimé avec succès',
        ], 200);
    }
}
