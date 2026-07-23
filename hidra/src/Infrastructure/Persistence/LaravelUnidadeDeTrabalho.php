<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use Illuminate\Support\Facades\DB;

final class LaravelUnidadeDeTrabalho implements UnidadeDeTrabalho
{
    public function executar(callable $operacao): mixed
    {
        return DB::transaction($operacao);
    }
}
