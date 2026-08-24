<?php

declare(strict_types=1);

namespace Tests\Feature\Pessoas;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

final class EnderecosViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_views_expoem_o_endereco_completo_do_proprietario(): void
    {
        $usuario = User::factory()->create();
        $colaboradorUuid = (string) Str::uuid();
        $fornecedorUuid = (string) Str::uuid();
        $clienteUuid = (string) Str::uuid();

        DB::table('colaboradores')->insert([
            'id' => $colaboradorUuid,
            'user_id' => $usuario->id,
        ]);
        DB::table('fornecedores')->insert([
            'id' => $fornecedorUuid,
            'user_id' => User::factory()->create()->id,
        ]);
        DB::table('clientes')->insert([
            'id' => $clienteUuid,
            'user_id' => User::factory()->create()->id,
        ]);

        $pais = DB::table('paises')->insertGetId([
            'pas_uuid' => (string) Str::uuid(),
            'nome' => 'Brasil',
            'sigla' => 'BR',
        ]);
        $uf = DB::table('ufs')->insertGetId([
            'est_uuid' => (string) Str::uuid(),
            'pais_id' => $pais,
            'nome' => 'São Paulo',
            'sigla' => 'SP',
        ]);
        $cidade = DB::table('cidades')->insertGetId([
            'cid_uuid' => (string) Str::uuid(),
            'uf_id' => $uf,
            'nome' => 'Campinas',
        ]);
        $endereco = DB::table('enderecos')->insertGetId([
            'end_uuid' => (string) Str::uuid(),
            'cep' => '13010-061',
            'logradouro' => 'Rua Barreto Leme',
            'numero' => '1200',
            'bairro' => 'Centro',
            'cidade_id' => $cidade,
        ]);

        DB::table('colaboradores_enderecos')->insert([
            'colaborador_id' => $colaboradorUuid,
            'endereco_id' => $endereco,
        ]);
        DB::table('fornecedores_enderecos')->insert([
            'fornecedor_id' => $fornecedorUuid,
            'endereco_id' => $endereco,
        ]);
        DB::table('clientes_enderecos')->insert([
            'cliente_id' => $clienteUuid,
            'endereco_id' => $endereco,
        ]);

        foreach ([
            'vw_colaborador_endereco' => ['colaborador_uuid' => $colaboradorUuid],
            'vw_fornecedor_endereco' => ['fornecedor_uuid' => $fornecedorUuid],
            'vw_cliente_endereco' => ['cliente_uuid' => $clienteUuid],
        ] as $view => $esperado) {
            $registro = DB::table($view)->first();

            self::assertNotNull($registro);
            self::assertSame('Campinas', $registro->cidade_nome);
            self::assertSame('SP', $registro->uf_sigla);
            self::assertSame('Brasil', $registro->pais_nome);
            self::assertSame($esperado[array_key_first($esperado)], $registro->{array_key_first($esperado)});
        }
    }
}
