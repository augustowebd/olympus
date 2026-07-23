<?php

declare(strict_types=1);

namespace App\Application\Producao\UseCases;

use App\Application\Producao\DTOs\AlterarNucleoDto;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Exceptions\NucleoNaoEncontradoException;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;

final readonly class AlterarNucleo
{
    public function __construct(
        private NucleoRepository $nucleos,
        private UnidadeDeTrabalho $unidadeDeTrabalho,
    ) {
    }

    public function executar(AlterarNucleoDto $dto): Nucleo
    {
        return $this->unidadeDeTrabalho->executar(function () use ($dto): Nucleo {
            $nucleo = $this->nucleos->obterPorId(NucleoId::fromString($dto->nucleoId));

            if ($nucleo === null) {
                throw new NucleoNaoEncontradoException();
            }

            $nucleo = $nucleo->renomear(Nome::deTexto($dto->nome));

            $this->nucleos->salvar($nucleo);

            return $nucleo;
        });
    }
}
