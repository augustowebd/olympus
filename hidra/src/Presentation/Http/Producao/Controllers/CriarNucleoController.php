<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Controllers;

use App\Application\Producao\DTOs\CriarNucleoDto;
use App\Application\Producao\UseCases\CriarNucleo;
use App\Presentation\Http\Producao\Contracts\NucleoPayload;
use App\Presentation\Http\Producao\Requests\CriarNucleoRequest;
use App\Presentation\Http\Producao\Resources\NucleoResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class CriarNucleoController
{
    public function __construct(
        private CriarNucleo $criarNucleo,
    ) {}

        public function __invoke(CriarNucleoRequest $request): JsonResponse
    {
        $dados = $request->validated();

        $nucleo = $this->criarNucleo->executar(
            new CriarNucleoDto(nome: $dados[NucleoPayload::NOME]),
        );

        return NucleoResource::make($nucleo)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
