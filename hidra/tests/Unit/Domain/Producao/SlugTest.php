<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Producao;

use App\Domain\Producao\ValueObjects\Slug;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class SlugTest extends TestCase
{
    public function test_deriva_slug_removendo_acento_e_normalizando_espacos(): void
    {
        $this->assertSame('galpao-sao-jose-02', Slug::deTexto('Galpão São José 02')->valor());
    }

    public function test_texto_sem_caracteres_validos_lanca_excecao(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('SLUG_INVALIDO');

        Slug::deTexto('   ');
    }
}
