---
name: mer-antes-de-persistir
description: Exigir que toda entidade de domínio persistida seja modelada em MER (DBML, padrão dbdiagram.io) antes da migration/model. Use sempre que for criar ou alterar uma tabela, migration ou model Eloquent no Hidra.
---

# MER antes de persistir

## Regra

Nenhuma tabela é criada sem antes existir no diagrama. Antes de escrever uma migration ou model Eloquent para uma entidade de domínio, ela precisa estar descrita no MER do projeto, em [DBML](https://dbml.dbdiagram.io) (a linguagem usada pelo dbdiagram.io).

O Hidra é o único projeto com banco (ver skill `arquitetura-ecossistema-granja` e `docs/database/README.md`) — logo o MER cobre só as tabelas do Hidra.

## Onde fica o diagrama

Arquivo único: `docs/database/erd.dbml`, organizado por contexto de domínio usando `TableGroup`. Um arquivo só porque é o que o dbdiagram.io espera colado direto (Import → DBML) sem montar nada.

```dbml
Project olympus {
  database_type: 'PostgreSQL'
  note: 'MER do Hidra — fonte de dados do ecossistema Olympus'
}

TableGroup vendas {
  vendas
  itens_venda
}

Table vendas {
  id uuid [pk]
  cliente_id uuid [null]
  status varchar [note: 'StatusVenda: ABERTA, AGUARDANDO_PAGAMENTO, PAGA, CANCELADA']
  total_centavos integer [not null]
  created_at timestamp
  updated_at timestamp
}

Table itens_venda {
  id uuid [pk]
  venda_id uuid [not null]
  produto_id uuid [not null]
  quantidade integer [not null]
  valor_unitario_centavos integer [not null]
}

Ref: itens_venda.venda_id > vendas.id
```

## Fluxo obrigatório

1. Identificar o contexto de domínio da entidade (Vendas, Entregas, Producao, Estoque, Pessoas).
2. Adicionar/atualizar a `Table` correspondente em `docs/database/erd.dbml`, com colunas, tipos, `pk`, `not null`/`null`, e `Ref:` para toda relação.
3. Validar o DBML colando em dbdiagram.io (ou `dbml2sql`/lint local, se disponível) antes de seguir.
4. Só então criar a migration e o model Eloquent em `Infrastructure/Persistence`, refletindo exatamente o que está no diagrama.
5. Atualizar a seção correspondente em `docs/database/README.md` no mesmo PR.

Diagrama, migration e model entram no mesmo PR — não em etapas separadas.

## Convenções no DBML

Seguem as mesmas de `docs/database/README.md`:

- `id uuid [pk]` — chave primária UUID.
- Dinheiro: `integer` com sufixo `_centavos`, nunca `float`/`decimal`.
- Status/enum: `varchar` com `note:` listando os valores do enum de domínio correspondente.
- Nome de tabela no plural, snake_case.
- Toda FK vira um `Ref:` explícito, nunca só um comentário.

## Proibido

- Criar migration sem a tabela existir antes no `erd.dbml`.
- Migration com colunas/tipos diferentes do que está descrito no diagrama sem atualizar o diagrama primeiro.
- Modelar segredo de infraestrutura (índices de performance, particionamento) no MER — isso é decisão de migration, não de modelo de domínio.

## Checklist final

- A entidade está em `docs/database/erd.dbml` antes da migration existir?
- Toda relação tem `Ref:`?
- Tipos batem com as convenções (UUID, centavos, enum como varchar)?
- `docs/database/README.md` foi atualizado no mesmo PR?
