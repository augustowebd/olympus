<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Entities;

use App\Domain\Pessoas\ValueObjects\FornecedorId;
use App\Domain\Pessoas\ValueObjects\UsuarioId;

final class Fornecedor extends Usuario
{
    public function __construct(
        private readonly FornecedorId $fornecedorId,
        UsuarioId $id,
        string $nome,
        string $email,
    ) {
        parent::__construct($id, $nome, $email);
    }

    public function fornecedorId(): FornecedorId
    {
        return $this->fornecedorId;
    }
}
