<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use Illuminate\Support\Facades\DB;

final class SchemaContexto
{
    /**
     * Qualifica o nome da tabela com o schema do contexto de domínio quando
     * o driver suporta schema (Postgres). Em drivers sem schema (sqlite, usado
     * nos testes), retorna o nome puro da tabela.
     *
     * ponytail: sqlite não suporta schema real; testes rodam sem qualificação,
     * Postgres real (dev/produção) usa o schema por contexto normalmente.
     */
    public static function tabela(string $contexto, string $tabela): string
    {
        return self::suportaSchema() ? "{$contexto}.{$tabela}" : $tabela;
    }

    public static function suportaSchema(): bool
    {
        return DB::connection()->getDriverName() === 'pgsql';
    }
}
