<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Entities;

use App\Domain\Pessoas\ValueObjects\UsuarioId;

class Usuario
{
    public function __construct(
        private readonly UsuarioId $id,
        private readonly string $nome,
        private readonly string $email,
    ) {}

    public function id(): UsuarioId
    {
        return $this->id;
    }

    public function nome(): string
    {
        return $this->nome;
    }

    public function email(): string
    {
        return $this->email;
    }
}
