<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface UnidadeDeTrabalho
{
    /**
     * @template T
     *
     * @param  callable(): T  $operacao
     * @return T
     */
    public function executar(callable $operacao): mixed;
}
