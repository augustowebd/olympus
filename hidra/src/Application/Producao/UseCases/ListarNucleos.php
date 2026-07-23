<?php

declare(strict_types=1);

namespace App\Application\Producao\UseCases;

use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Repositories\NucleoRepository;

final readonly class ListarNucleos
{
    public function __construct(
        private NucleoRepository $nucleos,
    ) {
    }

    /** @return list<Nucleo> */
    public function executar(): array
    {
        return $this->nucleos->listar();
    }
}
