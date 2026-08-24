<?php

declare(strict_types=1);

namespace App\Application\Producao\UseCases;

use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Exceptions\NucleoNaoEncontradoException;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\NucleoId;

final readonly class VisualizarNucleo
{
    public function __construct(
        private NucleoRepository $nucleos,
    ) {}

    public function executar(string $nucleoId): Nucleo
    {
        $nucleo = $this->nucleos->obterPorId(NucleoId::fromString($nucleoId));

        if ($nucleo === null) {
            throw new NucleoNaoEncontradoException;
        }

        return $nucleo;
    }
}
