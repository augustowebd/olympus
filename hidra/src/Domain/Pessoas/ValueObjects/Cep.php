<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\ValueObjects;

use App\Domain\Pessoas\Enums\CodigoErroEndereco;
use InvalidArgumentException;

final readonly class Cep
{
    private function __construct(private string $valor) {}

    public static function deTexto(string $valor): self
    {
        $normalizado = preg_replace('/\D/', '', $valor);
        if ($normalizado === null || strlen($normalizado) !== 8) {
            throw new InvalidArgumentException(CodigoErroEndereco::CEP_INVALIDO->value);
        }

        return new self($normalizado);
    }

    public function valor(): string
    {
        return $this->valor;
    }
}
