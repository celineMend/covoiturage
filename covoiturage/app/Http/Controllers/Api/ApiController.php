<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;  // Assure-toi que tu importes bien le Controller de base

class ApiController extends Controller
{
    /**
     * Authentification de l'utilisateur avec email et mot de passe.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'string'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            $token = auth()->attempt($credentials);
            if (!$token) {
                return response()->json(['message' => 'Informations de connexion incorrectes'], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => auth()->user(),
                'expires_in' => env('JWT_TTL') * 60 . ' seconds'
            ]);

        } catch (JWTException $e) {
            return response()->json(['message' => 'Impossible de créer un token'], 500);
        }
    }

    /**
     * Enregistrer un nouvel utilisateur et retourner un token JWT.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $token = auth()->login($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => env('JWT_TTL') * 60 . ' seconds'
        ]);
    }

    /**
     * Déconnecter l'utilisateur en révoquant le token JWT.
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Déconnexion réussie']);
    }

    /**
     * Rafraîchir le token JWT.
     */
    public function refresh()
    {
        try {
            $token = auth()->refresh();
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => auth()->user(),
                'expires_in' => env('JWT_TTL') * 60 . ' seconds'
            ]);

        } catch (JWTException $e) {
            return response()->json(['message' => 'Impossible de rafraîchir le token'], 500);
        }
    }
}
