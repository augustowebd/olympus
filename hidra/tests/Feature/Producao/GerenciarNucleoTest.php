<?php

declare(strict_types=1);

namespace Tests\Feature\Producao;

use App\Infrastructure\Persistence\Eloquent\Models\GalpaoModel;
use App\Infrastructure\Persistence\Eloquent\Models\NucleoModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class GerenciarNucleoTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_lista_visualiza_altera_e_remove_nucleo(): void
    {
        $usuario = $this->actingAs(User::factory()->create());

        $criar = $usuario->postJson('/api/v1/nucleos', ['nome' => 'Núcleo Central']);
        $criar->assertCreated();
        $criar->assertJsonPath('data.nome', 'Núcleo Central');
        $nclUuid = $criar->json('data.ncl_uuid');

        $listar = $usuario->getJson('/api/v1/nucleos');
        $listar->assertOk();
        $listar->assertJsonFragment(['ncl_uuid' => $nclUuid]);

        $visualizar = $usuario->getJson("/api/v1/nucleos/{$nclUuid}");
        $visualizar->assertOk();
        $visualizar->assertJsonPath('data.nome', 'Núcleo Central');

        $alterar = $usuario->putJson("/api/v1/nucleos/{$nclUuid}", ['nome' => 'Núcleo Renomeado']);
        $alterar->assertOk();
        $alterar->assertJsonPath('data.nome', 'Núcleo Renomeado');

        $remover = $usuario->deleteJson("/api/v1/nucleos/{$nclUuid}");
        $remover->assertNoContent();

        $usuario->getJson("/api/v1/nucleos/{$nclUuid}")->assertStatus(422);
    }

    public function test_retorna_422_ao_visualizar_nucleo_inexistente(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->getJson('/api/v1/nucleos/' . Str::uuid());

        $response->assertStatus(422);
        $response->assertJsonPath('error.code', 'NUCLEO_NAO_ENCONTRADO');
    }

    public function test_nao_remove_nucleo_com_galpao_vinculado(): void
    {
        $nucleo = NucleoModel::query()->create([
            'ncl_uuid' => (string) Str::uuid(),
            'nome' => 'Núcleo Central',
        ]);

        GalpaoModel::query()->create([
            'glp_uuid' => (string) Str::uuid(),
            'nome' => 'Galpão Norte 01',
            'slug' => 'galpao-norte-01',
            'capacidade' => 100,
            'nucleo_id' => $nucleo->id,
            'status' => 'DESOCUPADO',
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->deleteJson("/api/v1/nucleos/{$nucleo->ncl_uuid}");

        $response->assertStatus(422);
        $response->assertJsonPath('error.code', 'NUCLEO_EM_USO');
    }

    public function test_exige_autenticacao(): void
    {
        $this->getJson('/api/v1/nucleos')->assertStatus(401);
    }
}
