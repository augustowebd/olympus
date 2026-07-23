<?php

declare(strict_types=1);

namespace App\Domain\Producao\Repositories;

use App\Domain\Producao\Entities\Galpao;

interface GalpaoRepository
{
    public function salvar(Galpao $galpao): void;

    public function existeComSlug(string $slug): bool;
}
