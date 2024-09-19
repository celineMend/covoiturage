<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conducteur;
use Illuminate\Http\Request;

class ConducteurController extends Controller
{
    /**
     * Afficher une liste des conducteurs.
     */
    public function index()
    {
        $conducteurs = Conducteur::all();
        return response()->json([
            'status' => true,
            'message' => 'La liste des conducteurs',
            'data' => $conducteurs
        ]);
    }

    /**
     * Enregistrer un conducteur nouvellement créé dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'numero_permis' => 'required|string',
            'CIN' => 'required|string',
            'carte_gris' => 'required|string',
        ]);

        // Création d'un utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Création d'un conducteur associé
        $conducteur = Conducteur::create([
            'user_id' => $user->id,
            'numero_permis' => $request->numero_permis,
            'CIN' => $request->CIN,
            'carte_gris' => $request->carte_gris,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Conducteur créé avec succès',
            'data' => $conducteur
        ], 201);
    }

    /**
     * Afficher les détails d'un conducteur spécifié.
     */
    public function show(Conducteur $conducteur)
    {
        return response()->json([
            'status' => true,
            'message' => 'Détails du conducteur récupérés avec succès',
            'data' => $conducteur
        ]);
    }

    /**
     * Mettre à jour les informations d'un conducteur spécifique.
     */
    public function update(Request $request, $id)
    {
        $conducteur = Conducteur::find($id);

        if (!$conducteur) {
            return response()->json([
                'status' => false,
                'message' => 'Conducteur non trouvé'
            ], 404);
        }

        $user = $conducteur->user;

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur associé non trouvé'
            ], 404);
        }

        // Mettre à jour les informations de l'utilisateur
        $this->updateUser($request, $user->id);

        // Validation des données spécifiques au conducteur
        $request->validate([
            'numero_permis' => 'sometimes|string',
            'CIN' => 'sometimes|string',
            'carte_gris' => 'sometimes|string',
        ]);

        // Mettre à jour les informations du conducteur
        $conducteur->update([
            'numero_permis' => $request->numero_permis,
            'CIN' => $request->CIN,
            'carte_gris' => $request->carte_gris,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Informations du conducteur mises à jour avec succès',
            'data' => $conducteur
        ]);
    }

    /**
     * Mettre à jour les informations d'un utilisateur spécifique.
     */
    private function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Informations de l\'utilisateur mises à jour avec succès',
            'data' => $user
        ]);
    }







    // /**
    //  * Afficher le formulaire de modification du conducteur spécifié.
    //  */
    // public function edit(Conducteur $conducteur)
    // {
    //     //
    // }
    // public function update(Request $request, $id)
    // {
    //     // Trouver le conducteur par ID
    //     $conducteur = Conducteur::find($id);

    //     // Vérifier si le conducteur existe
    //     if (!$conducteur) {
    //         return response()->json([
    //             "status" => false,
    //             "message" => "Conducteur non trouvé"
    //         ], 404);
    //     }

    //     // Validation des données de la requête
    //     $validated = $request->validate([

    //         'permis_conduire' => 'sometime|string',
    //         'CIN' => 'sometime|string',
    //         'carte_gris' => 'sometime|string',
    //     ]);

    //     // Mettre à jour les informations de l'utilisateur
    //     $user = $conducteur->user;
    //     $user->email = $request->email;

    //     if ($request->filled('password')) {
    //         $user->password = bcrypt($request->password);
    //     }

    //     $user->save();

    //     // Mettre à jour les informations du conducteur
    //     $conducteur->update([

    //         'permis_conduire' => $request->permis_conduire,
    //         'CIN' => $request->CIN,
    //         'carte_gris' => $request->carte_gris
    //     ]);

    //     return response()->json([
    //         "status" => true,
    //         "message" => "Informations du conducteur mises à jour avec succès",
    //         "data" => [
    //             "user" => $user,
    //             "conducteur" => $conducteur
    //         ]
    //     ]);
    // }


    // /**
    //  * Supprimer un conducteur spécifié de la base de données.
    //  */
    // public function destroy(Conducteur $conducteur)
    // {

    // }
}
