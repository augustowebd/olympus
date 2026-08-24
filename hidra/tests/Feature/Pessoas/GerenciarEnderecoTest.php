<?php

declare(strict_types=1);

namespace Tests\Feature\Pessoas;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

final class GerenciarEnderecoTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_e_lista_endereco_de_colaborador(): void
    {
        $usuario = User::factory()->create();
        $colaborador = (string) Str::uuid();
        DB::table('colaboradores')->insert([
            'id' => $colaborador,
            'user_id' => $usuario->id,
        ]);
        $paisUuid = (string) Str::uuid();
        $pais = DB::table('paises')->insertGetId([
            'pas_uuid' => $paisUuid,
            'nome' => 'Brasil',
            'sigla' => 'BR',
        ]);
        $ufUuid = (string) Str::uuid();
        $uf = DB::table('ufs')->insertGetId([
            'est_uuid' => $ufUuid,
            'pais_id' => $pais,
            'nome' => 'São Paulo',
            'sigla' => 'SP',
        ]);
        $cidadeUuid = (string) Str::uuid();
        DB::table('cidades')->insert([
            'cid_uuid' => $cidadeUuid,
            'uf_id' => $uf,
            'nome' => 'Campinas',
        ]);
        $dados = [
            'cep' => '13010-061',
            'logradouro' => 'Rua Barreto Leme',
            'numero' => '1200',
            'bairro' => 'Centro',
            'pais_uuid' => $paisUuid,
            'uf_uuid' => $ufUuid,
            'cidade_uuid' => $cidadeUuid,
        ];
        $criar = $this->actingAs($usuario)->postJson(
            "/api/v1/colaborador/{$colaborador}/enderecos",
            $dados,
        );
        $criar->assertCreated()->assertJsonPath('data.cep', '13010061');
        $this->actingAs($usuario)
            ->getJson("/api/v1/colaborador/{$colaborador}/enderecos")
            ->assertOk()
            ->assertJsonPath('data.0.cidade_nome', 'Campinas');
    }
}
