<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Producao;

use App\Application\Producao\DTOs\AlterarNucleoDto;
use App\Application\Producao\DTOs\CriarNucleoDto;
use App\Application\Producao\UseCases\AlterarNucleo;
use App\Application\Producao\UseCases\CriarNucleo;
use App\Application\Producao\UseCases\ListarNucleos;
use App\Application\Producao\UseCases\RemoverNucleo;
use App\Application\Producao\UseCases\VisualizarNucleo;
use App\Application\Shared\Contracts\GeradorIdentificador;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Exceptions\NucleoNaoEncontradoException;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;
use PHPUnit\Framework\TestCase;

final class GerenciarNucleoTest extends TestCase
{
    private const string NUCLEO_ID = '22222222-2222-2222-2222-222222222222';

    private function unidadeDeTrabalhoSemTransacao(): UnidadeDeTrabalho
    {
        return new class implements UnidadeDeTrabalho {
            public function executar(callable $operacao): mixed
            {
                return $operacao();
            }
        };
    }

    private function geradorFixo(string $id): GeradorIdentificador
    {
        return new class ($id) implements GeradorIdentificador {
            public function __construct(private string $id)
            {
            }

            public function gerar(): string
            {
                return $this->id;
            }
        };
    }

    public function test_criar_nucleo_salva_e_retorna_entidade(): void
    {
        $salvo = null;

        $repositorio = new class ($salvo) implements NucleoRepository {
            public function __construct(private mixed &$salvo)
            {
            }

            public function salvar(Nucleo $nucleo): void
            {
                $this->salvo = $nucleo;
            }

            public function obterPorId(NucleoId $id): ?Nucleo
            {
                return null;
            }

            public function listar(): array
            {
                return [];
            }

            public function remover(NucleoId $id): void
            {
            }
        };

        $useCase = new CriarNucleo(
            nucleos: $repositorio,
            unidadeDeTrabalho: $this->unidadeDeTrabalhoSemTransacao(),
            geradorIdentificador: $this->geradorFixo(self::NUCLEO_ID),
        );

        $nucleo = $useCase->executar(new CriarNucleoDto(nome: 'Núcleo Central'));

        $this->assertSame(self::NUCLEO_ID, $nucleo->id()->valor());
        $this->assertSame('Núcleo Central', $nucleo->nome());
    }

    public function test_listar_nucleos_delega_ao_repositorio(): void
    {
        $esperado = [Nucleo::registrar(NucleoId::fromString(self::NUCLEO_ID), Nome::deTexto('Núcleo Central'))];

        $useCase = new ListarNucleos(
            nucleos: new class ($esperado) implements NucleoRepository {
                public function __construct(private array $lista)
                {
                }

                public function salvar(Nucleo $nucleo): void
                {
                }

                public function obterPorId(NucleoId $id): ?Nucleo
                {
                    return null;
                }

                public function listar(): array
                {
                    return $this->lista;
                }

                public function remover(NucleoId $id): void
                {
                }
            },
        );

        $this->assertSame($esperado, $useCase->executar());
    }

    public function test_visualizar_nucleo_lanca_excecao_quando_nao_existe(): void
    {
        $this->expectException(NucleoNaoEncontradoException::class);

        $useCase = new VisualizarNucleo(
            nucleos: new class implements NucleoRepository {
                public function salvar(Nucleo $nucleo): void
                {
                }

                public function obterPorId(NucleoId $id): ?Nucleo
                {
                    return null;
                }

                public function listar(): array
                {
                    return [];
                }

                public function remover(NucleoId $id): void
                {
                }
            },
        );

        $useCase->executar(self::NUCLEO_ID);
    }

    public function test_alterar_nucleo_renomeia_e_salva(): void
    {
        $salvo = null;

        $useCase = new AlterarNucleo(
            nucleos: new class ($salvo) implements NucleoRepository {
                public function __construct(private mixed &$salvo)
                {
                }

                public function salvar(Nucleo $nucleo): void
                {
                    $this->salvo = $nucleo;
                }

                public function obterPorId(NucleoId $id): ?Nucleo
                {
                    return Nucleo::registrar($id, Nome::deTexto('Nome Antigo'));
                }

                public function listar(): array
                {
                    return [];
                }

                public function remover(NucleoId $id): void
                {
                }
            },
            unidadeDeTrabalho: $this->unidadeDeTrabalhoSemTransacao(),
        );

        $nucleo = $useCase->executar(new AlterarNucleoDto(nucleoId: self::NUCLEO_ID, nome: 'Nome Novo'));

        $this->assertSame('Nome Novo', $nucleo->nome());
    }

    public function test_remover_nucleo_lanca_excecao_quando_nao_existe(): void
    {
        $this->expectException(NucleoNaoEncontradoException::class);

        $useCase = new RemoverNucleo(
            nucleos: new class implements NucleoRepository {
                public function salvar(Nucleo $nucleo): void
                {
                }

                public function obterPorId(NucleoId $id): ?Nucleo
                {
                    return null;
                }

                public function listar(): array
                {
                    return [];
                }

                public function remover(NucleoId $id): void
                {
                }
            },
            unidadeDeTrabalho: $this->unidadeDeTrabalhoSemTransacao(),
        );

        $useCase->executar(self::NUCLEO_ID);
    }
}
