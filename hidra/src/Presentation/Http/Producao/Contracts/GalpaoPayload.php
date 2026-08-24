<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Contracts;

final class GalpaoPayload
{
    public const string NOME = 'nome';

    public const string CAPACIDADE = 'capacidade';

    public const string NCL_UUID = 'ncl_uuid';

    private function __construct() {}
}
