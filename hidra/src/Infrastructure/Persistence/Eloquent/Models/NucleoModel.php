<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use App\Infrastructure\Persistence\SchemaContexto;
use Illuminate\Database\Eloquent\Model;

final class NucleoModel extends Model
{
    protected $table;

    protected $fillable = ['ncl_uuid', 'nome'];

    public function __construct(array $attributes = [])
    {
        $this->table = SchemaContexto::tabela('producao', 'nucleos');

        parent::__construct($attributes);
    }
}
