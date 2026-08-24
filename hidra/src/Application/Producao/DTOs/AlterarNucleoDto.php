<?php

declare(strict_types=1);

namespace App\Application\Producao\DTOs;

final readonly class AlterarNucleoDto
{
    public function __construct(
        public string $nucleoId,
        public string $nome,
    ) {}
}
