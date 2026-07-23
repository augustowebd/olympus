<?php

declare(strict_types=1);

namespace App\Domain\Producao\ValueObjects;

use App\Domain\Producao\Enums\CodigoErroProducao;
use InvalidArgumentException;

final readonly class Slug
{
    private function __construct(private string $valor)
    {
    }

    public static function deTexto(string $texto): self
    {
        $transliterado = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
        $transliterado = $transliterado === false ? $texto : $transliterado;

        $slug = strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '-', $transliterado));
        $slug = trim($slug, '-');

        if ($slug === '') {
            throw new InvalidArgumentException(
                CodigoErroProducao::SLUG_INVALIDO->value,
            );
        }

        return new self($slug);
    }

    public function valor(): string
    {
        return $this->valor;
    }
}
