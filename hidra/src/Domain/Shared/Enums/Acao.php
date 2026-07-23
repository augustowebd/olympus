<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enums;

enum Acao: string
{
    case CRIAR = 'criar';
    case VISUALIZAR = 'visualizar';
    case LISTAR = 'listar';
    case ALTERAR = 'alterar';
    case REMOVER = 'remover';
    case ATIVAR = 'ativar';
    case DESATIVAR = 'desativar';
}
