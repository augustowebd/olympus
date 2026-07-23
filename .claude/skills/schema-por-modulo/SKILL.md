---
name: schema-por-modulo
description: Exigir que toda tabela definida no MER exista de fato no banco e que cada tabela de domínio viva no schema Postgres do módulo/contexto ao qual pertence. Use sempre que criar, alterar ou remover uma tabela, migration ou o MER no Hidra.
---

# Schema por módulo

## Regra

1. Toda tabela descrita no MER (`docs/database/erd.dbml`) tem migration correspondente que a cria de fato no banco, e toda tabela migrada existe também no MER — nenhuma das duas fontes fica desatualizada em relação à outra (complementa a skill `mer-antes-de-persistir`).
2. Toda tabela de domínio vive num **schema Postgres nomeado pelo contexto de domínio** ao qual pertence — o mesmo nome usado em `src/Domain/<Contexto>` (ver skill `arquitetura-ecossistema-granja`): `pessoas`, `vendas`, `entregas`, `producao`, `estoque`.

Tabelas de framework/infraestrutura do Laravel (`users`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`, `sessions`, `password_reset_tokens`, `personal_access_tokens`, `migrations`) ficam no schema `public` — são mecanismo técnico, não domínio, e não pertencem a um módulo de negócio específico.

## Nomeação

- Schema: nome do contexto de domínio em pt-BR, minúsculo, sem acento (`pessoas`, `vendas`, `entregas`, `producao`, `estoque`).
- Tabela qualificada: `<schema>.<tabela>` (ex.: `pessoas.colaboradores`, `vendas.itens_venda`).

## MER (DBML)

dbdiagram.io aceita schema no nome da tabela:

```dbml
TableGroup pessoas {
  pessoas.colaboradores
  pessoas.fornecedores
  pessoas.clientes
}

Table pessoas.colaboradores {
  id uuid [pk]
  user_id integer [not null, unique, ref: > users.id]
  created_at timestamp
  updated_at timestamp
}
```

`users` continua sem prefixo — é tabela de framework, schema `public`.

## Migration

O schema é criado antes da tabela, se ainda não existir:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS pessoas');

        Schema::create('pessoas.colaboradores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoas.colaboradores');
    }
};
```

`constrained('users')` continua apontando pra tabela sem schema — resolvida em `public` pelo `search_path` padrão do Postgres.

## Eloquent

```php
final class ColaboradorModel extends Model
{
    protected $table = 'pessoas.colaboradores';
}
```

## Fluxo obrigatório

1. Identificar o contexto de domínio da tabela (mesmo critério da skill `mer-antes-de-persistir`).
2. Descrever/atualizar a tabela no MER já com o prefixo `<schema>.` (exceto tabela de framework).
3. A migration cria o schema (`CREATE SCHEMA IF NOT EXISTS`) antes de criar a tabela qualificada.
4. O model Eloquent aponta `$table` já qualificado com o schema.
5. Atualizar `docs/database/README.md` com o schema da tabela, na mesma seção de contexto, no mesmo PR.

## Proibido

- Tabela de domínio criada em `public` sem o schema do módulo.
- Tabela no MER sem o prefixo de schema correspondente (exceto tabela de framework do Laravel).
- Dois contextos de domínio diferentes compartilhando o mesmo schema.
- Foreign key entre schemas diferentes sem necessidade real — se dois contextos referenciam a mesma entidade o tempo todo, reavalie se são mesmo contextos separados.

## Checklist final

- A tabela existe de fato no banco via migration, refletindo exatamente o MER?
- A tabela está no schema do módulo/contexto correto, não em `public` (exceto tabela de framework)?
- O MER usa o prefixo `<schema>.<tabela>`?
- A migration cria o schema com `CREATE SCHEMA IF NOT EXISTS` antes da tabela?
- O model Eloquent aponta `$table` qualificado com o schema?
