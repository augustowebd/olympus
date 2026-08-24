<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Enums;

enum CodigoErroEndereco: string
{
    case CEP_INVALIDO = 'CEP_INVALIDO';
    case CAMPO_ENDERECO_OBRIGATORIO = 'CAMPO_ENDERECO_OBRIGATORIO';
    case LOCALIDADE_INVALIDA = 'LOCALIDADE_INVALIDA';
    case ENDERECO_NAO_ENCONTRADO = 'ENDERECO_NAO_ENCONTRADO';
    case ENDERECO_EM_USO = 'ENDERECO_EM_USO';
}
