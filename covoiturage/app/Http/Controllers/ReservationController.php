<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Afficher la liste des réservations.
     */
    public function index()
    {
        $reservations = Reservation::all();

        return response()->json([
            'status' => true,
            'message' => 'Liste des réservations récupérée avec succès',
            'data' => $reservations
        ], 200);
    }

    /**
     * Créer une nouvelle réservation.
     */
    public function store(Request $request)
    {
        // Validation des données entrantes
        $request->validate([
            'user_id' => 'required|exists:utilisateurs,id',
            'trajet_id' => 'required|exists:trajets,id',
            'date_reservation' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        // Création de la réservation avec toutes les données
        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'trajet_id' => $request->trajet_id,
            'date_reservation' => $request->date_reservation,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Réservation créée avec succès',
            'data' => $reservation
        ], 201);
    }

    /**
     * Afficher les détails d'une réservation spécifique.
     */
    public function show($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'status' => false,
                'message' => 'Réservation non trouvée',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Détails de la réservation récupérés avec succès',
            'data' => $reservation
        ], 200);
    }

    /**
     * Mettre à jour une réservation spécifique.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'status' => false,
                'message' => 'Réservation non trouvée',
            ], 404);
        }

        // Validation des données
        $request->validate([
            'user_id' => 'sometimes|required|exists:utilisateurs,id',
            'trajet_id' => 'sometimes|required|exists:trajets,id',
            'date_reservation' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:255',
        ]);

        // Mise à jour des informations
        $reservation->update($request->only([
            'user_id', 'trajet_id', 'date_reservation', 'status'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Réservation mise à jour avec succès',
            'data' => $reservation
        ], 200);
    }

    /**
     * Supprimer une réservation spécifique.
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'status' => false,
                'message' => 'Réservation non trouvée',
            ], 404);
        }

        $reservation->delete();

        return response()->json([
            'status' => true,
            'message' => 'Réservation supprimée avec succès',
        ], 200);
    }
}
