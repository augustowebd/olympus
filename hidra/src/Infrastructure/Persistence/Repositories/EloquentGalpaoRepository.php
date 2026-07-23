<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Producao\Entities\Galpao;
use App\Domain\Producao\Exceptions\NucleoNaoEncontradoException;
use App\Domain\Producao\Repositories\GalpaoRepository;
use App\Infrastructure\Persistence\Eloquent\Models\GalpaoModel;
use App\Infrastructure\Persistence\Eloquent\Models\NucleoModel;

final class EloquentGalpaoRepository implements GalpaoRepository
{
    public function salvar(Galpao $galpao): void
    {
        $nucleo = NucleoModel::query()
            ->where('ncl_uuid', $galpao->nucleoId()->valor())
            ->first();

        if ($nucleo === null) {
            throw new NucleoNaoEncontradoException();
        }

        GalpaoModel::query()->updateOrCreate(
            ['glp_uuid' => $galpao->id()->valor()],
            [
                'nome' => $galpao->nome(),
                'slug' => $galpao->slug()->valor(),
                'capacidade' => $galpao->capacidade()->valor(),
                'nucleo_id' => $nucleo->id,
                'status' => $galpao->status()->value,
            ],
        );
    }

    public function existeComSlug(string $slug): bool
    {
        return GalpaoModel::query()->where('slug', $slug)->exists();
    }
}
