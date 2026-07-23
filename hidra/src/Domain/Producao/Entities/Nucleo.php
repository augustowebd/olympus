<?php

declare(strict_types=1);

namespace App\Domain\Producao\Entities;

use App\Domain\Producao\Enums\CodigoErroProducao;
use App\Domain\Producao\ValueObjects\NucleoId;
use InvalidArgumentException;

final readonly class Nucleo
{
    private function __construct(
        private NucleoId $id,
        private string $nome,
    ) {
        if (trim($nome) === '') {
            throw new InvalidArgumentException(
                CodigoErroProducao::NOME_OBRIGATORIO->value,
            );
        }
    }

    public static function registrar(NucleoId $id, string $nome): self
    {
        return new self($id, $nome);
    }

    public function id(): NucleoId
    {
        return $this->id;
    }

    public function nome(): string
    {
        return $this->nome;
    }
}
