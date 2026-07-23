<?php

declare(strict_types=1);

namespace App\Application\Producao\UseCases;

use App\Application\Producao\DTOs\RegistrarGalpaoDto;
use App\Application\Shared\Contracts\GeradorIdentificador;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Producao\Entities\Galpao;
use App\Domain\Producao\Exceptions\NucleoNaoEncontradoException;
use App\Domain\Producao\Exceptions\SlugDuplicadoException;
use App\Domain\Producao\Repositories\GalpaoRepository;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\Capacidade;
use App\Domain\Producao\ValueObjects\GalpaoId;
use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;
use App\Domain\Producao\ValueObjects\Slug;

final readonly class RegistrarGalpao
{
    public function __construct(
        private GalpaoRepository $galpoes,
        private NucleoRepository $nucleos,
        private UnidadeDeTrabalho $unidadeDeTrabalho,
        private GeradorIdentificador $geradorIdentificador,
    ) {
    }

    public function executar(RegistrarGalpaoDto $dto): Galpao
    {
        return $this->unidadeDeTrabalho->executar(
            function () use ($dto): Galpao {
                $nucleoId = NucleoId::fromString($dto->nucleoId);
                $nome = Nome::deTexto($dto->nome);

                if ($this->nucleos->obterPorId($nucleoId) === null) {
                    throw new NucleoNaoEncontradoException();
                }

                if ($this->galpoes->existeComSlug(Slug::deTexto($nome->valor())->valor())) {
                    throw new SlugDuplicadoException();
                }

                $galpao = Galpao::registrar(
                    id: GalpaoId::fromString($this->geradorIdentificador->gerar()),
                    nome: $nome,
                    capacidade: Capacidade::deAves($dto->capacidade),
                    nucleoId: $nucleoId,
                );

                $this->galpoes->salvar($galpao);

                return $galpao;
            },
        );
    }
}
