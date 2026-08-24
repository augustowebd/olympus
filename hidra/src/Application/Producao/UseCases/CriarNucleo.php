<?php

declare(strict_types=1);

namespace App\Application\Producao\UseCases;

use App\Application\Producao\DTOs\CriarNucleoDto;
use App\Application\Shared\Contracts\GeradorIdentificador;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Exceptions\NucleoNomeDuplicadoException;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;

final readonly class CriarNucleo
{
    public function __construct(
        private NucleoRepository $nucleos,
        private UnidadeDeTrabalho $unidadeDeTrabalho,
        private GeradorIdentificador $geradorIdentificador,
    ) {}

    public function executar(CriarNucleoDto $dto): Nucleo
    {
        return $this->unidadeDeTrabalho->executar(function () use ($dto): Nucleo {
            $nome = Nome::deTexto($dto->nome);

            if ($this->nucleos->existeComNome($nome->valor())) {
                throw new NucleoNomeDuplicadoException;
            }

            $nucleo = Nucleo::registrar(
                id: NucleoId::fromString($this->geradorIdentificador->gerar()),
                nome: $nome,
            );

            $this->nucleos->salvar($nucleo);

            return $nucleo;
        });
    }
}
