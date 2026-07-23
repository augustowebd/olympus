<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enums;

enum Permissao: string
{
    case DEMETER_GALPAO_CRIAR = 'demeter.galpao.criar';

    case DEMETER_NUCLEO_CRIAR = 'demeter.nucleo.criar';
    case DEMETER_NUCLEO_LISTAR = 'demeter.nucleo.listar';
    case DEMETER_NUCLEO_VISUALIZAR = 'demeter.nucleo.visualizar';
    case DEMETER_NUCLEO_ALTERAR = 'demeter.nucleo.alterar';
    case DEMETER_NUCLEO_REMOVER = 'demeter.nucleo.remover';

    public static function compor(Modulo $modulo, string $funcionalidade, Acao $acao): string
    {
        return sprintf('%s.%s.%s', $modulo->value, $funcionalidade, $acao->value);
    }
}
