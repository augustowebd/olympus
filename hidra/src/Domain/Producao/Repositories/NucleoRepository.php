<?php

declare(strict_types=1);

namespace App\Domain\Producao\Repositories;

use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\ValueObjects\NucleoId;

interface NucleoRepository
{
    public function obterPorId(NucleoId $id): ?Nucleo;
}
