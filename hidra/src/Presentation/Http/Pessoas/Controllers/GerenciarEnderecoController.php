<?php

declare(strict_types=1);

namespace App\Presentation\Http\Pessoas\Controllers;

use App\Application\Pessoas\DTOs\EnderecoDto;
use App\Application\Pessoas\UseCases\GerenciarEndereco;
use App\Domain\Pessoas\Enums\TipoProprietarioEndereco;
use App\Presentation\Http\Pessoas\Requests\EnderecoRequest;
use App\Presentation\Http\Pessoas\Resources\EnderecoResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class GerenciarEnderecoController
{
    public function __construct(private GerenciarEndereco $enderecos)
    {
    }

        public function criar(EnderecoRequest $request, string $tipo, string $proprietarioUuid): JsonResponse
    {
        $endereco = $this->enderecos->criar(
            $this->dto($request->validated()),
            TipoProprietarioEndereco::from($tipo),
            $proprietarioUuid,
        );

        return EnderecoResource::make($endereco)->response()->setStatusCode(Response::HTTP_CREATED);
    }

        public function listar(string $tipo, string $proprietarioUuid): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->enderecos->listar(
                TipoProprietarioEndereco::from($tipo),
                $proprietarioUuid,
            ),
        ]);
    }

        public function visualizar(string $endUuid): EnderecoResource
    {
        return EnderecoResource::make($this->enderecos->visualizar($endUuid));
    }

        public function alterar(EnderecoRequest $request, string $endUuid): EnderecoResource
    {
        return EnderecoResource::make(
            $this->enderecos->alterar($endUuid, $this->dto($request->validated())),
        );
    }

        public function remover(string $endUuid): JsonResponse
    {
        $this->enderecos->remover($endUuid);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    private function dto(array $dados): EnderecoDto
    {
        return new EnderecoDto(
            $dados['cep'],
            $dados['logradouro'],
            $dados['numero'],
            $dados['complemento'] ?? null,
            $dados['bairro'],
            $dados['pais_uuid'],
            $dados['uf_uuid'],
            $dados['cidade_uuid'],
        );
    }
}
