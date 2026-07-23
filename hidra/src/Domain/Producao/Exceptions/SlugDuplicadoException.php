<?php

declare(strict_types=1);

namespace App\Domain\Producao\Exceptions;

use App\Domain\Producao\Enums\CodigoErroProducao;
use App\Domain\Shared\Exceptions\ExcecaoDeDominio;

final class SlugDuplicadoException extends ExcecaoDeDominio
{
    public function __construct()
    {
        parent::__construct(CodigoErroProducao::SLUG_DUPLICADO->value);
    }

    public function codigo(): CodigoErroProducao
    {
        return CodigoErroProducao::SLUG_DUPLICADO;
    }
}
