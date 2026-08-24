<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Enums;

enum TipoProprietarioEndereco: string
{
    case COLABORADOR = 'colaborador';
    case FORNECEDOR = 'fornecedor';
    case CLIENTE = 'cliente';
}
