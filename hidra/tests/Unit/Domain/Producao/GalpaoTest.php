<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Producao;

use App\Domain\Producao\Entities\Galpao;
use App\Domain\Producao\Enums\StatusGalpao;
use App\Domain\Producao\ValueObjects\Capacidade;
use App\Domain\Producao\ValueObjects\GalpaoId;
use App\Domain\Producao\ValueObjects\NucleoId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class GalpaoTest extends TestCase
{
    public function test_registrar_deriva_slug_do_nome_e_comeca_desocupado(): void
    {
        $galpao = Galpao::registrar(
            id: GalpaoId::fromString('11111111-1111-1111-1111-111111111111'),
            nome: 'Galpão Norte 01',
            capacidade: Capacidade::deAves(5000),
            nucleoId: NucleoId::fromString('22222222-2222-2222-2222-222222222222'),
        );

        $this->assertSame('galpao-norte-01', $galpao->slug()->valor());
        $this->assertSame(StatusGalpao::DESOCUPADO, $galpao->status());
        $this->assertSame(5000, $galpao->capacidade()->valor());
    }

    public function test_capacidade_zero_ou_negativa_lanca_excecao(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('CAPACIDADE_INVALIDA');

        Capacidade::deAves(0);
    }

    public function test_nome_vazio_lanca_excecao(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('NOME_OBRIGATORIO');

        Galpao::registrar(
            id: GalpaoId::fromString('11111111-1111-1111-1111-111111111111'),
            nome: '   ',
            capacidade: Capacidade::deAves(100),
            nucleoId: NucleoId::fromString('22222222-2222-2222-2222-222222222222'),
        );
    }
}
