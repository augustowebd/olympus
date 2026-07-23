<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Pessoas;

use App\Domain\Pessoas\Entities\Cliente;
use App\Domain\Pessoas\Entities\Colaborador;
use App\Domain\Pessoas\Entities\Fornecedor;
use App\Domain\Pessoas\Entities\Usuario;
use App\Domain\Pessoas\ValueObjects\ClienteId;
use App\Domain\Pessoas\ValueObjects\ColaboradorId;
use App\Domain\Pessoas\ValueObjects\FornecedorId;
use App\Domain\Pessoas\ValueObjects\UsuarioId;
use PHPUnit\Framework\TestCase;

final class TiposDeUsuarioTest extends TestCase
{
    public function test_colaborador_e_um_tipo_de_usuario(): void
    {
        $colaborador = new Colaborador(
            colaboradorId: ColaboradorId::fromString('c1'),
            id: UsuarioId::fromInt(1),
            nome: 'Ana',
            email: 'ana@olympus.test',
        );

        $this->assertInstanceOf(Usuario::class, $colaborador);
        $this->assertSame('c1', $colaborador->colaboradorId()->valor());
        $this->assertSame(1, $colaborador->id()->valor());
        $this->assertSame('ana@olympus.test', $colaborador->email());
    }

    public function test_fornecedor_e_um_tipo_de_usuario(): void
    {
        $fornecedor = new Fornecedor(
            fornecedorId: FornecedorId::fromString('f1'),
            id: UsuarioId::fromInt(2),
            nome: 'Fazenda Boa Vista',
            email: 'contato@boavista.test',
        );

        $this->assertInstanceOf(Usuario::class, $fornecedor);
        $this->assertSame('f1', $fornecedor->fornecedorId()->valor());
    }

    public function test_cliente_e_um_tipo_de_usuario(): void
    {
        $cliente = new Cliente(
            clienteId: ClienteId::fromString('cl1'),
            id: UsuarioId::fromInt(3),
            nome: 'Mercado Central',
            email: 'compras@mercadocentral.test',
        );

        $this->assertInstanceOf(Usuario::class, $cliente);
        $this->assertSame('cl1', $cliente->clienteId()->valor());
    }
}
