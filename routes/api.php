<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\CatalogoController;
use App\Http\Controllers\Api\V1\Auth\EmailVerificationController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\PersonaController;
use App\Http\Controllers\Api\V1\UbicacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Rutas públicas de autenticación
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('api.v1.auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('api.v1.auth.login');
        
        // Rutas de restablecimiento de contraseña (públicas)
        Route::prefix('password')->group(function () {
            Route::post('/forgot', [PasswordResetController::class, 'forgot'])->name('api.v1.password.forgot');
            Route::get('/reset', [PasswordResetController::class, 'showResetForm'])->name('api.v1.password.reset.form');
            Route::post('/reset', [PasswordResetController::class, 'reset'])->name('api.v1.password.reset');
        });

        // Verificación de email
        Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('api.v1.verification.verify');
    });

    // Rutas protegidas de autenticación
    Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.v1.auth.logout');
        Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('api.v1.auth.logout-all');
        Route::get('/me', [AuthController::class, 'me'])->name('api.v1.auth.me');
        
        // Reenviar verificación de email
        Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
            ->middleware('throttle:6,1')
            ->name('api.v1.verification.send');
    });

    // Rutas protegidas con autenticación
    Route::middleware('auth:sanctum')->group(function () {
        // Perfil
        Route::prefix('profile')->group(function () {
            Route::get('/', [PersonaController::class, 'profile'])->name('api.v1.profile.show');
        });

        // Personas (CRUD completo)
        Route::prefix('personas')->group(function () {
            Route::get('/', [PersonaController::class, 'index'])->name('api.v1.personas.index');
            Route::post('/', [PersonaController::class, 'store'])->name('api.v1.personas.store');
            Route::get('/{persona}', [PersonaController::class, 'show'])->name('api.v1.personas.show');
            Route::put('/{persona}', [PersonaController::class, 'update'])->name('api.v1.personas.update');
            Route::delete('/{persona}', [PersonaController::class, 'destroy'])->name('api.v1.personas.destroy');
        });

        // Ubicaciones
        Route::prefix('ubicaciones')->group(function () {
            Route::get('/paises', [UbicacionController::class, 'paises'])->name('api.v1.ubicaciones.paises');
            Route::get('/departamentos', [UbicacionController::class, 'departamentos'])->name('api.v1.ubicaciones.departamentos');
            Route::get('/departamentos/pais/{paisId}', [UbicacionController::class, 'departamentosByPais'])->name('api.v1.ubicaciones.departamentos-by-pais');
            Route::get('/municipios/departamento/{departamentoId}', [UbicacionController::class, 'municipiosByDepartamento'])->name('api.v1.ubicaciones.municipios-by-departamento');
        });

        // Catálogos
        Route::prefix('catalogos')->group(function () {
            Route::get('/temas', [CatalogoController::class, 'temas'])->name('api.v1.catalogos.temas');
            Route::get('/tema/{temaName}', [CatalogoController::class, 'parametrosPorTema'])->name('api.v1.catalogos.parametros-por-tema');
            Route::get('/parametros/{temaName}', [CatalogoController::class, 'parametros'])->name('api.v1.catalogos.parametros');
        });
    });
});

