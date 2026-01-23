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

        // Bindings de Actions Auth
        $this->app->singleton(RegisterAction::class, function ($app) {
            return new RegisterAction(
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->singleton(LoginAction::class, function ($app) {
            return new LoginAction(
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->singleton(LogoutAction::class);
        $this->app->singleton(LogoutAllAction::class, function ($app) {
            return new LogoutAllAction(
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->singleton(ForgotPasswordAction::class, function ($app) {
            return new ForgotPasswordAction(
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->singleton(ResetPasswordAction::class);

        $this->app->singleton(SendEmailVerificationAction::class);
        $this->app->singleton(VerifyEmailAction::class, function ($app) {
            return new VerifyEmailAction(
                $app->make(UserRepositoryInterface::class)
            );
        });

        // Bindings de Actions Persona
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
