<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enums;

enum Permissao: string
{
    case ARGOS_INICIO_VISUALIZAR = 'argos.inicio.visualizar';

    case DEMETER_GALPAO_CRIAR = 'demeter.galpao.criar';

    case DEMETER_NUCLEO_CRIAR = 'demeter.nucleo.criar';
    case DEMETER_NUCLEO_LISTAR = 'demeter.nucleo.listar';
    case DEMETER_NUCLEO_VISUALIZAR = 'demeter.nucleo.visualizar';
    case DEMETER_NUCLEO_ALTERAR = 'demeter.nucleo.alterar';
    case DEMETER_NUCLEO_REMOVER = 'demeter.nucleo.remover';

    case DEMETER_ENDERECO_CRIAR = 'demeter.endereco.criar';
    case DEMETER_ENDERECO_LISTAR = 'demeter.endereco.listar';
    case DEMETER_ENDERECO_VISUALIZAR = 'demeter.endereco.visualizar';
    case DEMETER_ENDERECO_ALTERAR = 'demeter.endereco.alterar';
    case DEMETER_ENDERECO_REMOVER = 'demeter.endereco.remover';

    public static function compor(Modulo $modulo, string $funcionalidade, Acao $acao): string
    {
        return sprintf('%s.%s.%s', $modulo->value, $funcionalidade, $acao->value);
    }
}
