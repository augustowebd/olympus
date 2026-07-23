<?php

declare(strict_types=1);

namespace App\Application\Producao\UseCases;

use App\Application\Producao\DTOs\AlterarNucleoDto;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Exceptions\NucleoNaoEncontradoException;
use App\Domain\Producao\Exceptions\NucleoNomeDuplicadoException;
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
            $id = NucleoId::fromString($dto->nucleoId);
            $nucleo = $this->nucleos->obterPorId($id);

            if ($nucleo === null) {
                throw new NucleoNaoEncontradoException();
            }

            $nome = Nome::deTexto($dto->nome);

            if ($this->nucleos->existeComNome($nome->valor(), ignorando: $id)) {
                throw new NucleoNomeDuplicadoException();
            }

            $nucleo = $nucleo->renomear($nome);

            $this->nucleos->salvar($nucleo);

            return $nucleo;
        });
    }
}
