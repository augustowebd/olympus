<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Producao;

use App\Application\Producao\DTOs\RegistrarGalpaoDto;
use App\Application\Producao\UseCases\RegistrarGalpao;
use App\Application\Shared\Contracts\GeradorIdentificador;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Domain\Producao\Entities\Galpao;
use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Exceptions\NucleoNaoEncontradoException;
use App\Domain\Producao\Exceptions\SlugDuplicadoException;
use App\Domain\Producao\Repositories\GalpaoRepository;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;
use PHPUnit\Framework\TestCase;

final class RegistrarGalpaoTest extends TestCase
{
    private const string NUCLEO_ID = '22222222-2222-2222-2222-222222222222';

    public function test_registra_galpao_quando_nucleo_existe_e_slug_e_livre(): void
    {
        $galpaoSalvo = null;

        $useCase = new RegistrarGalpao(
            galpoes: new class ($galpaoSalvo) implements GalpaoRepository {
                public function __construct(private mixed &$salvo)
                {
                }

                public function salvar(Galpao $galpao): void
                {
                    $this->salvo = $galpao;
                }

                public function existeComSlug(string $slug): bool
                {
                    return false;
                }
            },
            nucleos: new class implements NucleoRepository {
                public function salvar(Nucleo $nucleo): void
                {
                }

                public function obterPorId(NucleoId $id): ?Nucleo
                {
                    return Nucleo::registrar($id, Nome::deTexto('Núcleo 1'));
                }

                public function listar(): array
                {
                    return [];
                }

                public function remover(NucleoId $id): void
                {
                }
            },
            unidadeDeTrabalho: new class implements UnidadeDeTrabalho {
                public function executar(callable $operacao): mixed
                {
                    return $operacao();
                }
            },
            geradorIdentificador: new class implements GeradorIdentificador {
                public function gerar(): string
                {
                    return '11111111-1111-1111-1111-111111111111';
                }
            },
        );

        $galpao = $useCase->executar(new RegistrarGalpaoDto(
            nome: 'Galpão Norte 01',
            capacidade: 5000,
            nucleoId: self::NUCLEO_ID,
        ));

        $this->assertSame('11111111-1111-1111-1111-111111111111', $galpao->id()->valor());
        $this->assertSame('galpao-norte-01', $galpao->slug()->valor());
    }

    public function test_lanca_excecao_quando_nucleo_nao_existe(): void
    {
        $this->expectException(NucleoNaoEncontradoException::class);

        $useCase = new RegistrarGalpao(
            galpoes: new class implements GalpaoRepository {
                public function salvar(Galpao $galpao): void
                {
                }

                public function existeComSlug(string $slug): bool
                {
                    return false;
                }
            },
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
            unidadeDeTrabalho: new class implements UnidadeDeTrabalho {
                public function executar(callable $operacao): mixed
                {
                    return $operacao();
                }
            },
            geradorIdentificador: new class implements GeradorIdentificador {
                public function gerar(): string
                {
                    return '11111111-1111-1111-1111-111111111111';
                }
            },
        );

        $useCase->executar(new RegistrarGalpaoDto(
            nome: 'Galpão Norte 01',
            capacidade: 5000,
            nucleoId: self::NUCLEO_ID,
        ));
    }

    public function test_lanca_excecao_quando_slug_ja_existe(): void
    {
        $this->expectException(SlugDuplicadoException::class);

        $useCase = new RegistrarGalpao(
            galpoes: new class implements GalpaoRepository {
                public function salvar(Galpao $galpao): void
                {
                }

                public function existeComSlug(string $slug): bool
                {
                    return true;
                }
            },
            nucleos: new class implements NucleoRepository {
                public function salvar(Nucleo $nucleo): void
                {
                }

                public function obterPorId(NucleoId $id): ?Nucleo
                {
                    return Nucleo::registrar($id, Nome::deTexto('Núcleo 1'));
                }

                public function listar(): array
                {
                    return [];
                }

                public function remover(NucleoId $id): void
                {
                }
            },
            unidadeDeTrabalho: new class implements UnidadeDeTrabalho {
                public function executar(callable $operacao): mixed
                {
                    return $operacao();
                }
            },
            geradorIdentificador: new class implements GeradorIdentificador {
                public function gerar(): string
                {
                    return '11111111-1111-1111-1111-111111111111';
                }
            },
        );

        $useCase->executar(new RegistrarGalpaoDto(
            nome: 'Galpão Norte 01',
            capacidade: 5000,
            nucleoId: self::NUCLEO_ID,
        ));
    }
}
