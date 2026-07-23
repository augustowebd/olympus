<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;
use App\Infrastructure\Persistence\Eloquent\Models\NucleoModel;

final class EloquentNucleoRepository implements NucleoRepository
{
    public function obterPorId(NucleoId $id): ?Nucleo
    {
        $model = NucleoModel::query()->where('ncl_uuid', $id->valor())->first();

        if ($model === null) {
            return null;
        }

        return Nucleo::registrar(
            id: NucleoId::fromString($model->ncl_uuid),
            nome: Nome::deTexto($model->nome),
        );
    }
}
