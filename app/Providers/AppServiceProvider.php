<?php

namespace App\Providers;

use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\LogoutAllAction;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\ResetPasswordAction;
use App\Actions\Auth\SendEmailVerificationAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Actions\Persona\CreatePersonaAction;
use App\Actions\Persona\DeletePersonaAction;
use App\Actions\Persona\GetMyProfileAction;
use App\Actions\Persona\UpdatePersonaAction;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\PersonaRepository;
use App\Repositories\UserRepository;
use App\Services\Query\CatalogoQueryService;
use App\Services\Query\PersonaQueryService;
use App\Services\Query\UbicacionQueryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * Configura los bindings de interfaces a implementaciones concretas.
     */
    public function register(): void
    {
        // Bindings de Repositories
        $this->app->bind(PersonaRepositoryInterface::class, PersonaRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Bindings de Services
        $this->app->singleton(CatalogoQueryService::class);
        $this->app->singleton(PersonaQueryService::class, function ($app) {
            return new PersonaQueryService(
                $app->make(PersonaRepositoryInterface::class)
            );
        });
        $this->app->singleton(UbicacionQueryService::class);

        // Actions Auth - Laravel resuelve automáticamente las dependencias
        // No necesitan bindings manuales porque todas sus dependencias están registradas
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
