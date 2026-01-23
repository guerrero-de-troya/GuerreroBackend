<?php

namespace App\Providers;

use App\Actions\Persona\CreatePersonaAction;
use App\Actions\Persona\DeletePersonaAction;
use App\Actions\Persona\GetMyProfileAction;
use App\Actions\Persona\UpdatePersonaAction;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\PersonaRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\CatalogoService;
use App\Services\Query\PersonaQueryService;
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
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->singleton(PersonaQueryService::class, function ($app) {
            return new PersonaQueryService(
                $app->make(PersonaRepositoryInterface::class)
            );
        });

        $this->app->singleton(UbicacionService::class);

        // Bindings de Actions
        $this->app->singleton(CreatePersonaAction::class, function ($app) {
            return new CreatePersonaAction(
                $app->make(PersonaRepositoryInterface::class)
            );
        });

        $this->app->singleton(UpdatePersonaAction::class, function ($app) {
            return new UpdatePersonaAction(
                $app->make(PersonaRepositoryInterface::class)
            );
        });

        $this->app->singleton(DeletePersonaAction::class, function ($app) {
            return new DeletePersonaAction(
                $app->make(PersonaRepositoryInterface::class)
            );
        });

        $this->app->singleton(GetMyProfileAction::class, function ($app) {
            return new GetMyProfileAction(
                $app->make(PersonaQueryService::class)
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
