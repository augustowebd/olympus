<?php

declare(strict_types=1);

namespace App\Application\Producao\UseCases;

use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Producao\Exceptions\NucleoNaoEncontradoException;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\NucleoId;

final readonly class RemoverNucleo
{
    public function __construct(
        private NucleoRepository $nucleos,
        private UnidadeDeTrabalho $unidadeDeTrabalho,
    ) {
    }

    public function executar(string $nucleoId): void
    {
        $this->unidadeDeTrabalho->executar(function () use ($nucleoId): void {
            $id = NucleoId::fromString($nucleoId);

            if ($this->nucleos->obterPorId($id) === null) {
                throw new NucleoNaoEncontradoException();
            }

            $this->nucleos->remover($id);
        });
    }
}
