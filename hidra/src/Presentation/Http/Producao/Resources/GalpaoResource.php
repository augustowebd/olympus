<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Resources;

use App\Domain\Producao\Entities\Galpao;
use App\Domain\Producao\Enums\StatusGalpao;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Galpao $resource
 */
final class GalpaoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'glp_uuid' => $this->resource->id()->valor(),
            'nome' => $this->resource->nome(),
            'slug' => $this->resource->slug()->valor(),
            'capacidade' => $this->resource->capacidade()->valor(),
            'ncl_uuid' => $this->resource->nucleoId()->valor(),
            'status' => $this->resource->status()->value,
        ];
    }
}
