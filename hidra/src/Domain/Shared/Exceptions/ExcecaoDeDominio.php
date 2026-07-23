<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exceptions;

use BackedEnum;
use DomainException;

abstract class ExcecaoDeDominio extends DomainException
{
    abstract public function codigo(): BackedEnum;
}
