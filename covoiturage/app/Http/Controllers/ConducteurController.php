<?php

namespace App\Http\Controllers;

use App\Models\Conducteur;
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

    /**
     * Afficher le formulaire de modification du conducteur spécifié.
     */
    public function edit(Conducteur $conducteur)
    {
        //
    }

    /**
     * Mettre à jour les informations d'un conducteur spécifié dans la base de données.
     */
    public function update(UpdateConducteurRequest $request, Conducteur $conducteur)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Récupérer le conducteur associé à cet utilisateur
        $conducteur = Conducteur::where('user_id', $user->id)->first();

        // Vérifier si le conducteur existe
        if (!$conducteur) {
            return response()->json([
                "status" => false,
                "message" => "Conducteur non trouvé"
            ], 404);
        }

        // Validation des données de la requête
        $validator = validator(
            $request->all(),
            [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'password' => ['nullable', 'string', 'min:8'],
                'nom' => ['required', 'string'],
                'prenom' => ['required', 'string'],
                'telephone' => ['required', 'string', 'unique:conducteurs,telephone,' . $conducteur->id],
                'adresse' => ['required', 'string'],
                'vehicule' => ['required', 'string'],
                'numero_permis' => ['required', 'string'],
            ]
        );

        // Si les données ne sont pas valides, renvoyer les erreurs
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Mettre à jour les informations de l'utilisateur
        $user->email = $request->email;

        // Si un nouveau mot de passe est fourni, le mettre à jour
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Mettre à jour les informations du conducteur
        $conducteur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'vehicule' => $request->vehicule,
            'numero_permis' => $request->numero_permis,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Profil conducteur mis à jour avec succès",
            "data" => [
                "user" => $user,
                "conducteur" => $conducteur
            ]
        ]);
    }

    /**
     * Supprimer un conducteur spécifié de la base de données.
     */
    public function destroy(Conducteur $conducteur)
    {

    }
}
