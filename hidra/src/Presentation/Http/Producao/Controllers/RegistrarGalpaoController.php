<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Controllers;

use App\Application\Producao\DTOs\RegistrarGalpaoDto;
use App\Application\Producao\UseCases\RegistrarGalpao;
use App\Presentation\Http\Producao\Contracts\GalpaoPayload;
use App\Presentation\Http\Producao\Requests\RegistrarGalpaoRequest;
use App\Presentation\Http\Producao\Resources\GalpaoResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class RegistrarGalpaoController
{
    public function __construct(
        private RegistrarGalpao $registrarGalpao,
    ) {}

        public function __invoke(RegistrarGalpaoRequest $request): JsonResponse
    {
        $dados = $request->validated();

        $galpao = $this->registrarGalpao->executar(
            new RegistrarGalpaoDto(
                nome: $dados[GalpaoPayload::NOME],
                capacidade: $dados[GalpaoPayload::CAPACIDADE],
                nucleoId: $dados[GalpaoPayload::NCL_UUID],
            ),
        );

        return GalpaoResource::make($galpao)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
