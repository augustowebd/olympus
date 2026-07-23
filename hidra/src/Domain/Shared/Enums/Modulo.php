<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enums;

enum Modulo: string
{
    case HIDRA = 'hidra';
    case ARGOS = 'argos';
    case DEMETER = 'demeter';
    case HERMES = 'hermes';
    case PLUTO = 'pluto';
}
