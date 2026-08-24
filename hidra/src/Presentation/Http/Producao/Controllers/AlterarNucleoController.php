<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Controllers;

use App\Application\Producao\DTOs\AlterarNucleoDto;
use App\Application\Producao\UseCases\AlterarNucleo;
use App\Presentation\Http\Producao\Contracts\NucleoPayload;
use App\Presentation\Http\Producao\Requests\AlterarNucleoRequest;
use App\Presentation\Http\Producao\Resources\NucleoResource;

final readonly class AlterarNucleoController
{
    public function __construct(
        private AlterarNucleo $alterarNucleo,
    ) {}

        public function __invoke(AlterarNucleoRequest $request, string $nclUuid): NucleoResource
    {
        $dados = $request->validated();

        $nucleo = $this->alterarNucleo->executar(
            new AlterarNucleoDto(nucleoId: $nclUuid, nome: $dados[NucleoPayload::NOME]),
        );

        return NucleoResource::make($nucleo);
    }
}
