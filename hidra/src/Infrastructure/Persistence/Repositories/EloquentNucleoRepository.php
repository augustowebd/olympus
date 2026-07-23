<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Producao\Entities\Nucleo;
use App\Domain\Producao\Exceptions\NucleoEmUsoException;
use App\Domain\Producao\Repositories\NucleoRepository;
use App\Domain\Producao\ValueObjects\Nome;
use App\Domain\Producao\ValueObjects\NucleoId;
use App\Infrastructure\Persistence\Eloquent\Models\NucleoModel;
use Illuminate\Database\QueryException;

final class EloquentNucleoRepository implements NucleoRepository
{
    public function salvar(Nucleo $nucleo): void
    {
        NucleoModel::query()->updateOrCreate(
            ['ncl_uuid' => $nucleo->id()->valor()],
            ['nome' => $nucleo->nome()],
        );
    }

    public function obterPorId(NucleoId $id): ?Nucleo
    {
        $model = NucleoModel::query()->where('ncl_uuid', $id->valor())->first();

        if ($model === null) {
            return null;
        }

        return $this->paraDominio($model);
    }

    public function listar(): array
    {
        return NucleoModel::query()
            ->orderBy('nome')
            ->get()
            ->map(fn (NucleoModel $model): Nucleo => $this->paraDominio($model))
            ->all();
    }

    public function remover(NucleoId $id): void
    {
        try {
            NucleoModel::query()->where('ncl_uuid', $id->valor())->delete();
        } catch (QueryException $e) {
            if (stripos($e->getMessage(), 'foreign key') !== false) {
                throw new NucleoEmUsoException();
            }

            throw $e;
        }
    }

    private function paraDominio(NucleoModel $model): Nucleo
    {
        return Nucleo::registrar(
            id: NucleoId::fromString($model->ncl_uuid),
            nome: Nome::deTexto($model->nome),
        );
    }
}
