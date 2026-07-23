<?php

declare(strict_types=1);

namespace App\Infrastructure\Identifiers;

use App\Application\Shared\Contracts\GeradorIdentificador;
use Illuminate\Support\Str;

final class LaravelGeradorIdentificador implements GeradorIdentificador
{
    public function gerar(): string
    {
        return (string) Str::uuid();
    }
}
