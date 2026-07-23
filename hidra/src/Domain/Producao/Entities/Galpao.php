<?php

declare(strict_types=1);

namespace App\Domain\Producao\Entities;

use App\Domain\Producao\Enums\StatusGalpao;
use App\Domain\Producao\ValueObjects\Capacidade;
use App\Domain\Producao\ValueObjects\GalpaoId;
use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;
use App\Domain\Producao\ValueObjects\Slug;

final readonly class Galpao
{
    private function __construct(
        private GalpaoId $id,
        private Nome $nome,
        private Slug $slug,
        private Capacidade $capacidade,
        private NucleoId $nucleoId,
        private StatusGalpao $status,
    ) {
    }

    public static function registrar(
        GalpaoId $id,
        Nome $nome,
        Capacidade $capacidade,
        NucleoId $nucleoId,
    ): self {
        return new self(
            id: $id,
            nome: $nome,
            slug: Slug::deTexto($nome->valor()),
            capacidade: $capacidade,
            nucleoId: $nucleoId,
            status: StatusGalpao::DESOCUPADO,
        );
    }

    public function id(): GalpaoId
    {
        return $this->id;
    }

    public function nome(): string
    {
        return $this->nome->valor();
    }

    public function slug(): Slug
    {
        return $this->slug;
    }

    public function capacidade(): Capacidade
    {
        return $this->capacidade;
    }

    public function nucleoId(): NucleoId
    {
        return $this->nucleoId;
    }

    public function status(): StatusGalpao
    {
        return $this->status;
    }
}
