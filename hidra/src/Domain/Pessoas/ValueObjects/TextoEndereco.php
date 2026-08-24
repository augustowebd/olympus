<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\ValueObjects;

use App\Domain\Pessoas\Enums\CodigoErroEndereco;
use InvalidArgumentException;

final readonly class TextoEndereco
{
    private function __construct(private string $valor) {}

    public static function deTexto(string $valor): self
    {
        $valor = trim($valor);
        if ($valor === '') {
            throw new InvalidArgumentException(CodigoErroEndereco::CAMPO_ENDERECO_OBRIGATORIO->value);
        }

        return new self($valor);
    }

    public function valor(): string
    {
        return $this->valor;
    }
}
