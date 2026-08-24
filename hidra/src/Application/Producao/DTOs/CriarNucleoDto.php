<?php

declare(strict_types=1);

namespace App\Application\Producao\DTOs;

final readonly class CriarNucleoDto
{
    public function __construct(
        public string $nome,
    ) {}
}
