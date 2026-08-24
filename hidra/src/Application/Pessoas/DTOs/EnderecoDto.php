<?php

declare(strict_types=1);

namespace App\Application\Pessoas\DTOs;

final readonly class EnderecoDto
{
    public function __construct(
        public string $cep,
        public string $logradouro,
        public string $numero,
        public ?string $complemento,
        public string $bairro,
        public string $paisUuid,
        public string $ufUuid,
        public string $cidadeUuid
    ) {}
}
