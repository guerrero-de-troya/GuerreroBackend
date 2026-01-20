<?php

namespace App\Providers;

use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\PersonaRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\CatalogoService;
use App\Services\PersonaService;
use App\Services\UbicacionService;
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
        $this->app->singleton(CatalogoService::class);
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService(
                $app->make(UserRepositoryInterface::class),
                $app->make(PersonaRepositoryInterface::class)
            );
        });

        $this->app->singleton(PersonaService::class, function ($app) {
            return new PersonaService(
                $app->make(PersonaRepositoryInterface::class)
            );
        });

        $this->app->singleton(UbicacionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
