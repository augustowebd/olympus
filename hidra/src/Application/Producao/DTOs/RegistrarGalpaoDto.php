<?php

declare(strict_types=1);

namespace App\Application\Producao\DTOs;

final readonly class RegistrarGalpaoDto
{
    public function __construct(
        public string $nome,
        public int $capacidade,
        public string $nucleoId,
    ) {}
}
