<?php

declare(strict_types=1);

namespace App\Domain\Producao\ValueObjects;

use App\Domain\Producao\Enums\CodigoErroProducao;
use InvalidArgumentException;

final readonly class Nome
{
    private function __construct(private string $valor) {}

    public static function deTexto(string $valor): self
    {
        if (trim($valor) === '') {
            throw new InvalidArgumentException(
                CodigoErroProducao::NOME_OBRIGATORIO->value,
            );
        }

        return new self($valor);
    }

    public function valor(): string
    {
        return $this->valor;
    }
}
