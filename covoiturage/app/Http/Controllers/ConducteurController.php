<?php

// app/Http/Controllers/ConducteurController.php

namespace App\Http\Controllers;

use App\Models\Conducteur;
use Illuminate\Http\Request;

class ConducteurController extends Controller
{
    public function index()
    {
        $conducteurs = Conducteur::all();
        return response()->json($conducteurs);
    }

    public function show($id)
    {
        $conducteur = Conducteur::find($id);
        if (!$conducteur) {
            return response()->json(['message' => 'Conducteur not found'], 404);
        }
        return response()->json($conducteur);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
        ]);

        $conducteur = Conducteur::create($request->all());
        return response()->json($conducteur, 201);
    }

    public function update(Request $request, $id)
    {
        $conducteur = Conducteur::find($id);
        if (!$conducteur) {
            return response()->json(['message' => 'Conducteur not found'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'adresse' => 'sometimes|required|string',
            'telephone' => 'sometimes|required|string',
        ]);

        $conducteur->update($request->all());
        return response()->json($conducteur);
    }

    public function destroy($id)
    {
        $conducteur = Conducteur::find($id);
        if (!$conducteur) {
            return response()->json(['message' => 'Conducteur not found'], 404);
        }
        $conducteur->delete();
        return response()->json(['message' => 'Conducteur deleted successfully']);
    }
}
