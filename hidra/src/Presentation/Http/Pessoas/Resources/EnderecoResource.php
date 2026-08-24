<?php

declare(strict_types=1);

namespace App\Presentation\Http\Pessoas\Resources;

use App\Domain\Pessoas\Entities\Endereco;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Endereco $resource */
final class EnderecoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'end_uuid' => $this->resource->id()->valor(),
            'cep' => $this->resource->cep(),
            'logradouro' => $this->resource->logradouro(),
            'numero' => $this->resource->numero(),
            'complemento' => $this->resource->complemento(),
            'bairro' => $this->resource->bairro(),
            'cidade_uuid' => $this->resource->cidadeUuid(),
        ];
    }
}
