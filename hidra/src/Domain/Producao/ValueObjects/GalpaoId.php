<?php

declare(strict_types=1);

namespace App\Domain\Producao\ValueObjects;

final readonly class GalpaoId
{
    private function __construct(private string $valor)
    {
    }

    public static function fromString(string $valor): self
    {
        return new self($valor);
    }

    public function valor(): string
    {
        return $this->valor;
    }
}
