<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface GeradorIdentificador
{
    public function gerar(): string;
}
