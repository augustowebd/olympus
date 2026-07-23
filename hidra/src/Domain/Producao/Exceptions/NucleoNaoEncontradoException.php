<?php

declare(strict_types=1);

namespace App\Domain\Producao\Exceptions;

use App\Domain\Producao\Enums\CodigoErroProducao;
use App\Domain\Shared\Exceptions\ExcecaoDeDominio;

final class NucleoNaoEncontradoException extends ExcecaoDeDominio
{
    public function __construct()
    {
        parent::__construct(CodigoErroProducao::NUCLEO_NAO_ENCONTRADO->value);
    }

    public function codigo(): CodigoErroProducao
    {
        return CodigoErroProducao::NUCLEO_NAO_ENCONTRADO;
    }
}
