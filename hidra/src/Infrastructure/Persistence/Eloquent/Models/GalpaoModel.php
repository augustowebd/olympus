<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use App\Infrastructure\Persistence\SchemaContexto;
use Illuminate\Database\Eloquent\Model;

final class GalpaoModel extends Model
{
    protected $table;

    protected $fillable = ['glp_uuid', 'nome', 'slug', 'capacidade', 'nucleo_id', 'status'];

    public function __construct(array $attributes = [])
    {
        $this->table = SchemaContexto::tabela('producao', 'galpoes');

        parent::__construct($attributes);
    }
}
