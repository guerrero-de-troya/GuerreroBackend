<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\PersonaController;
use Illuminate\Support\Facades\Route;

// Rutas públicas de autenticación
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

// Rutas protegidas de autenticación
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('auth.logout-all');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
});

// Rutas de verificación de email
Route::middleware('auth:sanctum')->prefix('email')->group(function () {
    Route::post('/verification-notification', [EmailVerificationController::class, 'send'])
        ->name('verification.send');
    Route::get('/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify.post');
});

// Rutas de restablecimiento de contraseña
Route::prefix('password')->group(function () {
    Route::post('/forgot', [PasswordResetController::class, 'forgot'])->name('password.forgot');
    Route::post('/reset', [PasswordResetController::class, 'reset'])->name('password.reset');
});

// Rutas de perfil
Route::middleware('auth:sanctum')->prefix('profile')->group(function () {
    Route::get('/', [PersonaController::class, 'profile'])->name('profile.show');
});

// Rutas de personas
Route::middleware('auth:sanctum')->prefix('personas')->group(function () {
    Route::get('/', [PersonaController::class, 'index'])->name('personas.index');
    Route::get('/{persona}', [PersonaController::class, 'show'])->name('personas.show');
    Route::put('/{persona}', [PersonaController::class, 'update'])->name('personas.update');
    Route::patch('/{persona}', [PersonaController::class, 'update'])->name('personas.patch');
    Route::delete('/{persona}', [PersonaController::class, 'destroy'])->name('personas.destroy');
});
