<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class AutenticacaoTest extends TestCase
{
    public function test_autentica_no_hidra_e_cria_sessao(): void
    {
        Http::fake([
            '*' => Http::response([
                'data' => [
                    'token' => 'token-hidra',
                    'nome' => 'Administrador',
                    'permissoes' => ['*'],
                ],
            ]),
        ]);

        $this->post('/login', [
            'username' => 'admin',
            'password' => 'Qaz123',
        ])->assertRedirect('/')
            ->assertSessionHas('hidra_token', 'token-hidra');
    }

    public function test_rejeita_campos_invalidos_sem_consultar_o_hidra(): void
    {
        Http::fake();

        $this->from('/login')
            ->post('/login', [
                'username' => 'usuario',
                'password' => 'abcd',
            ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors(['username', 'password']);

        Http::assertNothingSent();
    }

    public function test_exibe_o_painel_para_usuario_autenticado(): void
    {
        $this->withSession([
            'hidra_token' => 'token-hidra',
            'nome_usuario' => 'Administrador',
        ])->get('/')
            ->assertOk()
            ->assertSee('Painel geral')
            ->assertSee('Administrador')
            ->assertSee('Sair');
    }

    public function test_sair_invalida_a_sessao(): void
    {
        $this->withSession(['hidra_token' => 'token-hidra'])
            ->post('/sair')
            ->assertRedirect('/login')
            ->assertSessionMissing('hidra_token');
    }

    public function test_exibe_o_cadastro_de_colaborador_para_usuario_autenticado(): void
    {
        $this->withSession([
            'hidra_token' => 'token-hidra',
            'permissoes' => ['argos.colaborador.criar'],
        ])->get('/colaboradores?modo=novo')
            ->assertOk()
            ->assertSee('Novo colaborador')
            ->assertSee('Dados familiares');
    }

    public function test_exibe_grid_de_colaboradores_por_padrao(): void
    {
        $this->withSession(['hidra_token' => 'token-hidra'])
            ->get('/colaboradores')
            ->assertOk()
            ->assertSee('Nenhum colaborador cadastrado')
            ->assertDontSee('modo=novo');
    }
}
