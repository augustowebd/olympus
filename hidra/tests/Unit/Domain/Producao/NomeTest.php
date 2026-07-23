<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Producao;

use App\Domain\Producao\ValueObjects\Nome;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class NomeTest extends TestCase
{
    public function test_aceita_texto_valido(): void
    {
        $this->assertSame('Galpão Norte 01', Nome::deTexto('Galpão Norte 01')->valor());
    }

    public function test_texto_vazio_ou_so_espacos_lanca_excecao(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('NOME_OBRIGATORIO');

        Nome::deTexto('   ');
    }
}
