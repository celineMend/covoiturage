<?php

use App\Http\Controllers\TrajetController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\ConducteurController;

// Routes pour l'enregistrement, la connexion, et la gestion des tokens
Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::post('/logout', [ApiController::class, 'logout']);
Route::post('/refresh-token', [ApiController::class, 'refreshToken']);

// Routes protégées par authentification
Route::middleware('auth:api')->group(function () {
    // Routes pour Conducteurs
    Route::apiResource('conducteurs', ConducteurController::class);

    // Routes pour Trajets
    Route::apiResource('trajets', TrajetController::class);
    // Route pour vehicule
    Route::apiResource('vehicules', VehiculeController::class);

});
