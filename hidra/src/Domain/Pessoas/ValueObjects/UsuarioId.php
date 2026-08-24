<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\ValueObjects;

final readonly class UsuarioId
{
    private function __construct(private int $valor) {}

    public static function fromInt(int $valor): self
    {
        return new self($valor);
    }

    public function valor(): int
    {
        return $this->valor;
    }
}
