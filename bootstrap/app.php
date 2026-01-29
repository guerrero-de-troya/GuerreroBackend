<?php

use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.abilities' => CheckAbilities::class,
            'check.any.ability' => CheckForAnyAbility::class,
            'optional.auth.sanctum' => \App\Http\Middleware\OptionalAuthSanctum::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle validation errors consistently for API routes
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // Handle custom API exceptions
        $exceptions->render(function (ApiException $e, Request $request) {
            if ($request->is('api/*')) {
                return $e->render();
            }
        });

        // Handle ModelNotFoundException for API routes
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Recurso no encontrado',
                    ],
                    404
                );
            }
        });

        $exceptions->render(function (InvalidSignatureException $e, Request $request) {
            if ($request->is('api/*') && $request->is('*auth/email/verify*') && ! $request->expectsJson()) {
                $base = rtrim(Config::get('app.frontend_url', Config::get('app.url')), '/');

                return redirect($base.'/verificar-email?'.http_build_query(['verified' => '0', 'error' => 'Enlace inválido o expirado.']));
            }

            if ($request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Enlace inválido o expirado.'], 403);
            }
        });
    })->create();
