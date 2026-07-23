---
name: identificadores-internos-e-publicos
description: Padronizar os dois tipos de identificador de toda tabela de domínio no Hidra — chave interna (id integer, nunca exposta) e identificador público (uuid prefixado com a sigla de 3 letras da entidade, usado em links/API). Use sempre que criar ou alterar tabela, migration, entidade de domínio ou model Eloquent.
---

# Identificadores internos e públicos

## Regra

Toda tabela de entidade de domínio tem **dois identificadores**, com papéis diferentes e nunca intercambiáveis:

1. **Chave interna** — `id` (integer, autoincrement, PK física da tabela). Usada só pra ligação interna no banco (foreign key, join). **Nunca** é repassada como link, nunca aparece em resposta de API, rota, ou qualquer lugar visível a um consumidor externo.
2. **Identificador público** — `<sigla3>uuid` (uuid, `unique`, `not null`). É o identificador visível: usado em URLs (`/api/v1/galpoes/{glpuuid}`), no corpo das respostas, e em qualquer referência que atravesse a fronteira HTTP. `<sigla3>` é a abreviação de três letras da entidade.

```text
galpao -> glpuuid
nucleo -> ncluuid
colaborador -> claboradr... (3 letras: clb)
venda -> vnd
```

Sigla de 3 letras: as três primeiras consoantes/letras mais identificáveis do nome da entidade, minúsculas, sem acento — escolha uma vez e documente no MER; não mude depois (é o prefixo de coluna e às vezes de rota).

## Onde cada um vive

- **Infrastructure**: única camada que conhece o `id` interno. Model Eloquent usa `id` como chave primária normal (autoincrement), e mapeia `<sigla3>uuid` como atributo comum. Foreign keys entre tabelas usam sempre o `id` interno da tabela referenciada (`nucleo_id` aponta pra `nucleos.id`, não pra `ncluuid`).
- **Domain e Application**: não sabem que o `id` interno existe. A identidade de uma entidade de domínio (`GalpaoId`, `NucleoId`, ...) **é** o uuid público — o Value Object de identidade envolve o valor de `<sigla3>uuid`, nunca o inteiro.
- **Presentation**: rotas, resources e requests usam exclusivamente o identificador público.

Isso é o que garante a regra: identificador que vira link nunca é o `id` interno.

## MER (DBML)

```dbml
Table producao.nucleos {
  id integer [pk, increment, note: 'uso interno, nunca exposto']
  ncl_uuid uuid [unique, not null, note: 'identificador publico']
  nome varchar [not null]
  created_at timestamp
  updated_at timestamp
}

Table producao.galpoes {
  id integer [pk, increment, note: 'uso interno, nunca exposto']
  glp_uuid uuid [unique, not null, note: 'identificador publico']
  nucleo_id integer [not null, ref: > producao.nucleos.id, note: 'FK interna — nunca exposta, usar ncl_uuid do nucleo pra referencia publica']
}
```

## Migration

```php
Schema::create('producao.nucleos', function (Blueprint $table) {
    $table->id();
    $table->uuid('ncl_uuid')->unique();
    $table->string('nome');
    $table->timestamps();
});

Schema::create('producao.galpoes', function (Blueprint $table) {
    $table->id();
    $table->uuid('glp_uuid')->unique();
    $table->string('nome');
    $table->string('slug')->unique();
    $table->unsignedInteger('capacidade');
    $table->foreignId('nucleo_id')->constrained('producao.nucleos')->restrictOnDelete();
    $table->string('status');
    $table->timestamps();
});
```

## Domain

```php
final readonly class GalpaoId
{
    private function __construct(private string $valor)
    {
    }

    public static function fromString(string $valor): self
    {
        return new self($valor);
    }

    public function valor(): string
    {
        return $this->valor;
    }
}
```

O Value Object de identidade não sabe e não precisa saber do `id` interno — ele só existe na tabela/model Eloquent.

## Proibido

- Expor o `id` interno em resposta HTTP, rota, log de auditoria voltado ao usuário, ou qualquer link.
- Foreign key apontando para `<sigla3>uuid` em vez do `id` interno da tabela referenciada.
- Domain ou Application conhecerem/manipularem o `id` interno.
- Tabela de entidade de domínio sem os dois identificadores (só `id`, ou só `<sigla3>uuid`).
- Trocar a sigla de 3 letras de uma entidade depois de definida.

## Checklist final

- A tabela tem `id` interno (PK, autoincrement) e `<sigla3>uuid` (unique, not null)?
- Toda foreign key aponta pro `id` interno da tabela referenciada?
- O Value Object de identidade no Domain envolve o uuid público, nunca o `id` interno?
- Rotas, resources e requests usam só o identificador público?
- Nenhuma resposta de API expõe o `id` interno?
