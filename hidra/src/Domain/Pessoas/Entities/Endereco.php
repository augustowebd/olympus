<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Entities;

use App\Domain\Pessoas\ValueObjects\Cep;
use App\Domain\Pessoas\ValueObjects\EnderecoId;
use App\Domain\Pessoas\ValueObjects\TextoEndereco;

final readonly class Endereco
{
    private function __construct(
        private EnderecoId $id,
        private Cep $cep,
        private TextoEndereco $logradouro,
        private TextoEndereco $numero,
        private ?string $complemento,
        private TextoEndereco $bairro,
        private string $cidadeUuid,
    ) {
    }

    public static function registrar(
        EnderecoId $id,
        Cep $cep,
        TextoEndereco $logradouro,
        TextoEndereco $numero,
        ?string $complemento,
        TextoEndereco $bairro,
        string $cidadeUuid,
    ): self
    {
        return new self(
            $id,
            $cep,
            $logradouro,
            $numero,
            $complemento === null ? null : trim($complemento),
            $bairro,
            $cidadeUuid,
        );
    }

    public function id(): EnderecoId
    {
        return $this->id;
    }

    public function cep(): string
    {
        return $this->cep->valor();
    }

    public function logradouro(): string
    {
        return $this->logradouro->valor();
    }

    public function numero(): string
    {
        return $this->numero->valor();
    }

    public function complemento(): ?string
    {
        return $this->complemento;
    }

    public function bairro(): string
    {
        return $this->bairro->valor();
    }

    public function cidadeUuid(): string
    {
        return $this->cidadeUuid;
    }
}
