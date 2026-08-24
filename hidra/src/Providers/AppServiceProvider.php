<?php

namespace App\Providers;

use App\Application\Shared\Contracts\GeradorIdentificador;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Pessoas\Repositories\EnderecoRepository;
use App\Domain\Producao\Repositories\GalpaoRepository;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Infrastructure\Identifiers\LaravelGeradorIdentificador;
use App\Infrastructure\Persistence\LaravelUnidadeDeTrabalho;
use App\Infrastructure\Persistence\Repositories\EloquentEnderecoRepository;
use App\Infrastructure\Persistence\Repositories\EloquentGalpaoRepository;
use App\Infrastructure\Persistence\Repositories\EloquentNucleoRepository;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
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
        $this->app->bind(EnderecoRepository::class, EloquentEnderecoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Scramble::extendOpenApi(function (OpenApi $openApi): void {
            $openApi->secure(SecurityScheme::http('bearer'));
        });
    }
}
