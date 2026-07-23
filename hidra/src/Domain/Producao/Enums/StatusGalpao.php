<?php

declare(strict_types=1);

namespace App\Domain\Producao\Enums;

enum StatusGalpao: string
{
    case OCUPADO = 'OCUPADO';
    case DESOCUPADO = 'DESOCUPADO';
    case VAZIO_SANITARIO = 'VAZIO_SANITARIO';
}
