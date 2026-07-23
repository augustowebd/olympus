<?php

namespace App\Providers;

use App\Application\Shared\Contracts\GeradorIdentificador;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Producao\Repositories\GalpaoRepository;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Infrastructure\Identifiers\LaravelGeradorIdentificador;
use App\Infrastructure\Persistence\LaravelUnidadeDeTrabalho;
use App\Infrastructure\Persistence\Repositories\EloquentGalpaoRepository;
use App\Infrastructure\Persistence\Repositories\EloquentNucleoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GeradorIdentificador::class, LaravelGeradorIdentificador::class);
        $this->app->bind(UnidadeDeTrabalho::class, LaravelUnidadeDeTrabalho::class);
        $this->app->bind(GalpaoRepository::class, EloquentGalpaoRepository::class);
        $this->app->bind(NucleoRepository::class, EloquentNucleoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
