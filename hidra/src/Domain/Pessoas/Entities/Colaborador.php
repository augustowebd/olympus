<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Entities;

use App\Domain\Pessoas\ValueObjects\ColaboradorId;
use App\Domain\Pessoas\ValueObjects\UsuarioId;

final class Colaborador extends Usuario
{
    public function __construct(
        private readonly ColaboradorId $colaboradorId,
        UsuarioId $id,
        string $nome,
        string $email,
    ) {
        parent::__construct($id, $nome, $email);
    }

    public function colaboradorId(): ColaboradorId
    {
        return $this->colaboradorId;
    }
}
