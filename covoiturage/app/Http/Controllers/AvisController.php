<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function index()
    {
        $avis = Avis::all();
        return response()->json($avis);
    }

    public function show($id)
    {
        $avis = Avis::find($id);
        if (!$avis) {
            return response()->json(['message' => 'Avis not found'], 404);
        }
        return response()->json($avis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'trajet_id' => 'required|exists:trajets,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        $avis = Avis::create($request->all());
        return response()->json($avis, 201);
    }

    public function update(Request $request, $id)
    {
        $avis = Avis::find($id);
        if (!$avis) {
            return response()->json(['message' => 'Avis not found'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'trajet_id' => 'sometimes|required|exists:trajets,id',
            'note' => 'sometimes|required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        $avis->update($request->all());
        return response()->json($avis);
    }

    public function destroy($id)
    {
        $avis = Avis::find($id);
        if (!$avis) {
            return response()->json(['message' => 'Avis not found'], 404);
        }
        $avis->delete();
        return response()->json(['message' => 'Avis deleted successfully']);
    }
}
