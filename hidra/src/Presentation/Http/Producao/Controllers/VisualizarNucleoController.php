<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Controllers;

use App\Application\Producao\UseCases\VisualizarNucleo;
use App\Presentation\Http\Producao\Resources\NucleoResource;

final readonly class VisualizarNucleoController
{
    public function __construct(
        private VisualizarNucleo $visualizarNucleo,
    ) {
    }

    public function __invoke(string $nclUuid): NucleoResource
    {
        return NucleoResource::make($this->visualizarNucleo->executar($nclUuid));
    }
}
