<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Controllers;

use App\Application\Producao\UseCases\ListarNucleos;
use App\Presentation\Http\Producao\Resources\NucleoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class ListarNucleosController
{
    public function __construct(
        private ListarNucleos $listarNucleos,
    ) {}

        public function __invoke(): AnonymousResourceCollection
    {
        return NucleoResource::collection($this->listarNucleos->executar());
    }
}
