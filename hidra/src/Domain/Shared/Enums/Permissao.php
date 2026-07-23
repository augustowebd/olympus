<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enums;

enum Permissao: string
{
    case DEMETER_GALPAO_CRIAR = 'demeter.galpao.criar';

    public static function compor(Modulo $modulo, string $funcionalidade, Acao $acao): string
    {
        return sprintf('%s.%s.%s', $modulo->value, $funcionalidade, $acao->value);
    }
}
