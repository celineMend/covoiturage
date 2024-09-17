
<?php
use App\Http\Controllers\Api\ApiController;

Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::post('/logout', [ApiController::class, 'logout']);
Route::post('/refresh-token', [ApiController::class, 'refreshToken']);

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ApiController::class, 'profile']);
    Route::post('/logout', [ApiController::class, 'logout']);
});