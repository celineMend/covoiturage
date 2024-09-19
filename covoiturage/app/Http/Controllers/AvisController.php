<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    /**
     * Afficher la liste des avis.
     */
    public function index()
    {
        $avis = Avis::all();

        return response()->json([
            'status' => true,
            'message' => 'Liste des avis récupérée avec succès',
            'data' => $avis
        ], 200);
    }

    /**
     * Créer un nouvel avis.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données entrantes
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id', // L'utilisateur qui laisse l'avis
                'trajet_id' => 'required|exists:trajets,id', // Le trajet concerné par l'avis
                'note' => 'required|integer|min:1|max:5', // Note entre 1 et 5
                'commentaire' => 'nullable|string|max:1000', // Optionnel: un commentaire
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation échouée',
                'errors' => $e->errors()
            ], 422);
        }

        // Création de l'avis
        $avis = Avis::create($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Avis créé avec succès',
            'data' => $avis
        ], 201);
    }

    /**
     * Afficher un avis spécifique.
     */
    public function show($id)
    {
        $avis = Avis::find($id);

        if (!$avis) {
            return response()->json([
                'status' => false,
                'message' => 'Avis non trouvé',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Détails de l\'avis récupérés avec succès',
            'data' => $avis
        ], 200);
    }

    /**
     * Mettre à jour un avis spécifique.
     */
    public function update(Request $request, $id)
    {
        $avis = Avis::find($id);

        if (!$avis) {
            return response()->json([
                'status' => false,
                'message' => 'Avis non trouvé',
            ], 404);
        }

        // Validation des données entrantes
        $request->validate([
            'note' => 'sometimes|required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        // Mise à jour des informations de l'avis
        $avis->update($request->only('note', 'commentaire'));

        return response()->json([
            'status' => true,
            'message' => 'Avis mis à jour avec succès',
            'data' => $avis
        ], 200);
    }

    /**
     * Supprimer un avis spécifique.
     */
    public function destroy($id)
    {
        $avis = Avis::find($id);

        if (!$avis) {
            return response()->json([
                'status' => false,
                'message' => 'Avis non trouvé',
            ], 404);
        }

        $avis->delete();

        return response()->json([
            'status' => true,
            'message' => 'Avis supprimé avec succès',
        ], 200);
    }
}
