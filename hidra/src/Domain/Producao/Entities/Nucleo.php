<?php

declare(strict_types=1);

namespace App\Domain\Producao\Entities;

use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;

final readonly class Nucleo
{
    private function __construct(
        private NucleoId $id,
        private Nome $nome,
    ) {
    }

    public static function registrar(NucleoId $id, Nome $nome): self
    {
        return new self($id, $nome);
    }

    public function id(): NucleoId
    {
        return $this->id;
    }

    public function nome(): string
    {
        return $this->nome->valor();
    }
}
