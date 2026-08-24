<?php

declare(strict_types=1);

namespace App\Application\Pessoas\UseCases;

use App\Application\Pessoas\DTOs\EnderecoDto;
use App\Application\Shared\Contracts\GeradorIdentificador;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Pessoas\Entities\Endereco;
use App\Domain\Pessoas\Enums\TipoProprietarioEndereco;
use App\Domain\Pessoas\Exceptions\EnderecoEmUsoException;
use App\Domain\Pessoas\Exceptions\EnderecoNaoEncontradoException;
use App\Domain\Pessoas\Exceptions\LocalidadeInvalidaException;
use App\Domain\Pessoas\Repositories\EnderecoRepository;
use App\Domain\Pessoas\ValueObjects\Cep;
use App\Domain\Pessoas\ValueObjects\EnderecoId;
use App\Domain\Pessoas\ValueObjects\TextoEndereco;

final readonly class GerenciarEndereco
{
    public function __construct(
        private EnderecoRepository $enderecos,
        private UnidadeDeTrabalho $unidadeDeTrabalho,
        private GeradorIdentificador $geradorIdentificador,
    ) {
    }

    public function criar(EnderecoDto $dto, TipoProprietarioEndereco $tipo, string $proprietarioUuid): Endereco
    {
        return $this->unidadeDeTrabalho->executar(function () use (
            $dto,
            $tipo,
            $proprietarioUuid,
        ): Endereco {
            $endereco = $this->montar(
                EnderecoId::fromString($this->geradorIdentificador->gerar()),
                $dto,
            );
            $this->enderecos->salvar($endereco);
            $this->enderecos->vincular($tipo, $proprietarioUuid, $endereco->id());

            return $endereco;
        });
    }

    public function alterar(string $uuid, EnderecoDto $dto): Endereco
    {
        $id = EnderecoId::fromString($uuid);
        if ($this->enderecos->obter($id) === null) {
            throw new EnderecoNaoEncontradoException;
        }

        $endereco = $this->montar($id, $dto);
        $this->enderecos->salvar($endereco);

        return $endereco;
    }

    public function visualizar(string $uuid): Endereco
    {
        return $this->enderecos->obter(EnderecoId::fromString($uuid))
            ?? throw new EnderecoNaoEncontradoException;
    }

    public function listar(TipoProprietarioEndereco $tipo, string $proprietarioUuid): array
    {
        return $this->enderecos->listar($tipo, $proprietarioUuid);
    }

    public function remover(string $uuid): void
    {
        $id = EnderecoId::fromString($uuid);
        if ($this->enderecos->obter($id) === null) {
            throw new EnderecoNaoEncontradoException;
        }

        if ($this->enderecos->estaVinculado($id)) {
            throw new EnderecoEmUsoException;
        }

        $this->enderecos->remover($id);
    }

    private function montar(EnderecoId $id, EnderecoDto $dto): Endereco
    {
        if (! $this->enderecos->localidadeExiste(
            $dto->paisUuid,
            $dto->ufUuid,
            $dto->cidadeUuid,
        )) {
            throw new LocalidadeInvalidaException;
        }

        return Endereco::registrar(
            $id,
            Cep::deTexto($dto->cep),
            TextoEndereco::deTexto($dto->logradouro),
            TextoEndereco::deTexto($dto->numero),
            $dto->complemento,
            TextoEndereco::deTexto($dto->bairro),
            $dto->cidadeUuid,
        );
    }
}
