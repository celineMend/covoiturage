<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        return response()->json($reservations);
    }

    public function show($id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        return response()->json($reservation);
    }

    public function store(Request $request)
    {
        $request->validate([
            'passager_id' => 'required|exists:passagers,id',
            'trajet_id' => 'required|exists:trajets,id',
            'date_heure_reservation' => 'required|date',
            'statut' => 'required|in:annuler,confirmer',
        ]);

        $reservation = Reservation::create($request->all());
        return response()->json($reservation, 201);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $request->validate([
            'passager_id' => 'sometimes|required|exists:passagers,id',
            'trajet_id' => 'sometimes|required|exists:trajets,id',
            'date_heure_reservation' => 'sometimes|required|date',
            'statut' => 'sometimes|required|in:annuler,confirmer',
        ]);

        $reservation->update($request->all());
        return response()->json($reservation);
    }

    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
