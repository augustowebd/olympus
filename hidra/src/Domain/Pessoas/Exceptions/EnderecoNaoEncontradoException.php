<?php

declare(strict_types=1);

namespace App\Domain\Pessoas\Exceptions;

use App\Domain\Pessoas\Enums\CodigoErroEndereco;
use App\Domain\Shared\Exceptions\ExcecaoDeDominio;

final class EnderecoNaoEncontradoException extends ExcecaoDeDominio
{
    public function __construct()
    {
        parent::__construct(CodigoErroEndereco::ENDERECO_NAO_ENCONTRADO->value);
    }

    public function codigo(): CodigoErroEndereco
    {
        return CodigoErroEndereco::ENDERECO_NAO_ENCONTRADO;
    }
}
