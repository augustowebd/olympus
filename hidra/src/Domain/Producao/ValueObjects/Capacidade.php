<?php

declare(strict_types=1);

namespace App\Domain\Producao\ValueObjects;

use App\Domain\Producao\Enums\CodigoErroProducao;
use InvalidArgumentException;

final readonly class Capacidade
{
    public const int MINIMA = 1;

    private function __construct(private int $valor)
    {
        if ($valor < self::MINIMA) {
            throw new InvalidArgumentException(
                CodigoErroProducao::CAPACIDADE_INVALIDA->value,
            );
        }
    }

    public static function deAves(int $valor): self
    {
        return new self($valor);
    }

    public function valor(): int
    {
        return $this->valor;
    }
}
