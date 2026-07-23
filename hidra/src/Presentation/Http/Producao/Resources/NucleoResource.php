<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Resources;

use App\Domain\Producao\Entities\Nucleo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Nucleo $resource
 */
final class NucleoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ncl_uuid' => $this->resource->id()->valor(),
            'nome' => $this->resource->nome(),
        ];
    }
}
