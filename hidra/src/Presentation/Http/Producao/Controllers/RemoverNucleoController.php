<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Controllers;

use App\Application\Producao\UseCases\RemoverNucleo;
use Illuminate\Http\Response;

final readonly class RemoverNucleoController
{
    public function __construct(
        private RemoverNucleo $removerNucleo,
    ) {}

        public function __invoke(string $nclUuid): Response
    {
        $this->removerNucleo->executar($nclUuid);

        return response()->noContent();
    }
}
