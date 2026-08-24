<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Repositories;

use App\Domain\Pessoas\Entities\Endereco;
use App\Domain\Pessoas\Enums\TipoProprietarioEndereco;
use App\Domain\Pessoas\ValueObjects\EnderecoId;

interface EnderecoRepository
{
    public function salvar(Endereco $endereco): void;

    public function obter(EnderecoId $id): ?Endereco;

    public function localidadeExiste(string $paisUuid, string $ufUuid, string $cidadeUuid): bool;

    public function vincular(TipoProprietarioEndereco $tipo, string $proprietarioUuid, EnderecoId $enderecoId): void;

    public function listar(TipoProprietarioEndereco $tipo, string $proprietarioUuid): array;

    public function estaVinculado(EnderecoId $id): bool;

    public function remover(EnderecoId $id): void;
}
