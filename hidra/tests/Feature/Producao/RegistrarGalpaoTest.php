<?php

declare(strict_types=1);

namespace Tests\Feature\Producao;

use App\Infrastructure\Persistence\Eloquent\Models\NucleoModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class RegistrarGalpaoTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_galpao_com_sucesso(): void
    {
        $nucleo = NucleoModel::query()->create([
            'ncl_uuid' => (string) Str::uuid(),
            'nome' => 'Núcleo 1',
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->postJson('/api/v1/galpoes', [
                'nome' => 'Galpão Norte 01',
                'capacidade' => 5000,
                'ncl_uuid' => $nucleo->ncl_uuid,
            ]);

        $response->assertCreated();
        $response->assertJsonPath('data.nome', 'Galpão Norte 01');
        $response->assertJsonPath('data.slug', 'galpao-norte-01');
        $response->assertJsonPath('data.status', 'DESOCUPADO');
        $response->assertJsonPath('data.ncl_uuid', $nucleo->ncl_uuid);
        $response->assertJsonMissingPath('data.id');
    }

    public function test_retorna_422_quando_nucleo_nao_existe(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->postJson('/api/v1/galpoes', [
                'nome' => 'Galpão Norte 01',
                'capacidade' => 5000,
                'ncl_uuid' => (string) Str::uuid(),
            ]);

        $response->assertStatus(422);
        $response->assertJsonPath('error.code', 'NUCLEO_NAO_ENCONTRADO');
    }

    public function test_retorna_422_quando_capacidade_invalida(): void
    {
        $nucleo = NucleoModel::query()->create([
            'ncl_uuid' => (string) Str::uuid(),
            'nome' => 'Núcleo 1',
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->postJson('/api/v1/galpoes', [
                'nome' => 'Galpão Norte 01',
                'capacidade' => 0,
                'ncl_uuid' => $nucleo->ncl_uuid,
            ]);

        $response->assertStatus(422);
    }

    public function test_exige_autenticacao(): void
    {
        $response = $this->postJson('/api/v1/galpoes', [
            'nome' => 'Galpão Norte 01',
            'capacidade' => 5000,
            'ncl_uuid' => (string) Str::uuid(),
        ]);

        $response->assertStatus(401);
    }
}
