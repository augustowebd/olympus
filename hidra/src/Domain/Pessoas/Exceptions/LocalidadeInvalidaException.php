<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Exceptions;

use App\Domain\Pessoas\Enums\CodigoErroEndereco;
use App\Domain\Shared\Exceptions\ExcecaoDeDominio;

final class LocalidadeInvalidaException extends ExcecaoDeDominio
{
    public function __construct()
    {
        parent::__construct(CodigoErroEndereco::LOCALIDADE_INVALIDA->value);
    }

    public function codigo(): CodigoErroEndereco
    {
        return CodigoErroEndereco::LOCALIDADE_INVALIDA;
    }
}
