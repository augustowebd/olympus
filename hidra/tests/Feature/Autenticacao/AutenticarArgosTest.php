<?php

declare(strict_types=1);

namespace Tests\Feature\Autenticacao;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AutenticarArgosTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_autentica_no_argos(): void
    {
        $this->postJson('/api/v1/autenticacoes/argos', [
            'username' => 'admin',
            'password' => 'Qaz123',
        ])->assertOk()
            ->assertJsonPath('data.eh_administrador', true)
            ->assertJsonPath('data.permissoes.0', '*');
    }

    public function test_rejeita_credenciais_invalidas(): void
    {
        $this->postJson('/api/v1/autenticacoes/argos', [
            'username' => 'admin',
            'password' => 'invalida1',
        ])->assertUnprocessable()
            ->assertJsonPath('error.code', 'CREDENCIAIS_INVALIDAS');
    }

    public function test_rejeita_usuario_que_nao_seja_admin_ou_email(): void
    {
        $this->postJson('/api/v1/autenticacoes/argos', [
            'username' => 'usuario',
            'password' => 'senha1',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('username');
    }

    public function test_rejeita_senha_fora_das_regras(): void
    {
        $this->postJson('/api/v1/autenticacoes/argos', [
            'username' => 'admin',
            'password' => 'abcd',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('password');
    }
}
