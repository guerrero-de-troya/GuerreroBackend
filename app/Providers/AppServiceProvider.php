<?php

namespace App\Providers;

use App\Repositories\Contracts\DepartamentoRepositoryInterface;
use App\Repositories\Contracts\MunicipioRepositoryInterface;
use App\Repositories\Contracts\ParametroRepositoryInterface;
use App\Repositories\Contracts\ParametroTemaRepositoryInterface;
use App\Repositories\Contracts\PaisRepositoryInterface;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\Contracts\TemaRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\DepartamentoRepository;
use App\Repositories\MunicipioRepository;
use App\Repositories\ParametroRepository;
use App\Repositories\ParametroTemaRepository;
use App\Repositories\PaisRepository;
use App\Repositories\PersonaRepository;
use App\Repositories\TemaRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
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
        // Bindings de Repositories (orden importante por dependencias)
        $this->app->bind(TemaRepositoryInterface::class, TemaRepository::class);
        $this->app->bind(ParametroRepositoryInterface::class, ParametroRepository::class);
        $this->app->bind(ParametroTemaRepositoryInterface::class, ParametroTemaRepository::class);
        $this->app->bind(PersonaRepositoryInterface::class, PersonaRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Bindings de Services
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

        $this->app->singleton(UbicacionService::class, function ($app) {
            return new UbicacionService(
                $app->make(PaisRepositoryInterface::class),
                $app->make(DepartamentoRepositoryInterface::class),
                $app->make(MunicipioRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
