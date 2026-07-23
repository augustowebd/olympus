<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Entities;

use App\Domain\Pessoas\ValueObjects\ClienteId;
use App\Domain\Pessoas\ValueObjects\UsuarioId;

final class Cliente extends Usuario
{
    public function __construct(
        private readonly ClienteId $clienteId,
        UsuarioId $id,
        string $nome,
        string $email,
    ) {
        parent::__construct($id, $nome, $email);
    }

    public function clienteId(): ClienteId
    {
        return $this->clienteId;
    }
}
