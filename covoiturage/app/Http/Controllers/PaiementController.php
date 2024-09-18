<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::all();
        return response()->json($paiements);
    }

    public function show($id)
    {
        $paiement = Paiement::find($id);
        if (!$paiement) {
            return response()->json(['message' => 'Paiement not found'], 404);
        }
        return response()->json($paiement);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
        ]);

        $paiement = Paiement::create($request->all());
        return response()->json($paiement, 201);
    }

    public function update(Request $request, $id)
    {
        $paiement = Paiement::find($id);
        if (!$paiement) {
            return response()->json(['message' => 'Paiement not found'], 404);
        }

        $request->validate([
            'reservation_id' => 'sometimes|required|exists:reservations,id',
            'montant' => 'sometimes|required|numeric',
            'date_paiement' => 'sometimes|required|date',
        ]);

        $paiement->update($request->all());
        return response()->json($paiement);
    }

    public function destroy($id)
    {
        $paiement = Paiement::find($id);
        if (!$paiement) {
            return response()->json(['message' => 'Paiement not found'], 404);
        }
        $paiement->delete();
        return response()->json(['message' => 'Paiement deleted successfully']);
    }
}
