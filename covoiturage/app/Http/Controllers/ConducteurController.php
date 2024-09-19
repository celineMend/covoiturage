<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conducteur;
use Illuminate\Http\Request;
use App\Http\Requests\StoreConducteurRequest;
use App\Http\Requests\UpdateConducteurRequest;

class ConducteurController extends Controller
{
    /**
     * Afficher une liste des conducteurs.
     */
    public function index()
    {
        // Méthode pour récupérer la liste des conducteurs
        $conducteurs = Conducteur::all();
        return response()->json([
            'status' => true,
            'message' => 'La liste des conducteurs',
            'data' => $conducteurs
        ]);
    }

    /**
     * Afficher le formulaire de création d'un nouveau conducteur.
     */
    public function create()
    {
        //
    }

    /**
     * Enregistrer un conducteur nouvellement créé dans la base de données.
     */
    public function store(StoreConducteurRequest $request)
    {
        // Création d'un nouveau conducteur

    }

    /**
     * Afficher les détails d'un conducteur spécifié.
     */
    public function show(Conducteur $conducteur)
    {

    }



    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $request->validate([
            'nom' => 'sometime|string',
            'prenom' => 'sometime|string',
            'email' => 'sometime|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

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

    public function update(Request $request, $id)
    {
        // Récupérer le conducteur par ID
        $conducteur = Conducteur::find($id);

        if (!$conducteur) {
            return response()->json([
                'status' => false,
                'message' => 'Conducteur non trouvé'
            ], 404);
        }

        // Récupérer l'utilisateur associé
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
