# Modelo de Banco de Dados

## Fonte da verdade

O Hidra é o único projeto com banco de dados. Migrations vivem em `hidra/database/migrations` e são a fonte executável do schema — este documento é a referência de leitura (diagrama, dicionário, decisões), não substitui as migrations.

Argos, Demeter, Hermes e Pluto não têm banco próprio de dados de negócio: tudo é consumido via API do Hidra (ver skill `arquitetura-ecossistema-granja`).

## Organização por contexto de domínio

As tabelas seguem os mesmos contextos de domínio do Hidra (`src/Domain/<Contexto>`): Vendas, Entregas, Producao, Estoque, Pessoas.

Cada contexto documentado aqui ganha uma seção com:

- diagrama ER (ou descrição textual das entidades e relações);
- dicionário de campos relevantes (nome, tipo, restrições, significado de negócio);
- decisões de modelagem que não são óbvias pela migration (ex.: por que um campo é `centavos` inteiro e não `decimal`).

## Convenções de migration

- Valores monetários: inteiro em centavos, nunca `float`/`decimal` (ver skill de arquitetura, Value Object `Dinheiro`).
- Identificadores: `id` interno (integer autoincrement, só ligação/FK, nunca exposto) + `<sigla3>uuid` (uuid público, usado em API/links) — ver skill `identificadores-internos-e-publicos`. `Pessoas` (`colaboradores`/`fornecedores`/`clientes`) ainda usa UUID puro como PK, anterior a essa convenção — pendente de alinhamento, não é o padrão pra tabelas novas.
- Toda tabela de entidade de domínio vive no schema Postgres do seu contexto de domínio (`producao.galpoes`, `vendas.itens_venda`) — ver skill `schema-por-contexto-de-dominio`.
- Enums de status/tipo: coluna `string` com os valores do enum de domínio (ex.: `StatusVenda`), nunca inteiro mágico.
- Toda tabela de entidade de domínio tem `created_at`/`updated_at`; `deleted_at` (soft delete) só quando o domínio precisar de histórico, não por padrão.
- Nome de tabela no plural em snake_case, alinhado ao nome do agregado (`vendas`, `itens_venda`).

## Diagramas

MER completo em [`erd.dbml`](./erd.dbml) — DBML (padrão dbdiagram.io), colar em https://dbdiagram.io para visualizar (ver skill `mer-antes-de-persistir`).

### Pessoas

`users` (tabela padrão do Laravel) é o centro de verdade de identidade: todo colaborador, fornecedor e cliente é, antes de tudo, um `user`. Colaborador/Fornecedor/Cliente são **tipos (papéis) de usuário**, não uma tabela única com coluna `tipo` — cada papel é uma tabela satélite com `user_id` único apontando para `users.id`. Um mesmo usuário pode acumular mais de um papel (ex.: colaborador que também é cliente).

```text
            .-[colaboradores]
            |
[users] <---+-[fornecedores]
            |
            .-[clientes]
```

| Tabela | Chave | Relação |
|---|---|---|
| `users` | `id` bigint autoincrement | central — tabela de framework/auth, não usa UUID |
| `colaboradores` | `id` uuid | `user_id` único → `users.id` |
| `fornecedores` | `id` uuid | `user_id` único → `users.id` |
| `clientes` | `id` uuid | `user_id` único → `users.id` |

Essa hierarquia de dados é espelhada nas classes de domínio: `Domain\Pessoas\Entities\Usuario` é a base, e `Colaborador`, `Fornecedor` e `Cliente` estendem `Usuario` (`src/Domain/Pessoas/Entities`).

Endereços ficam no schema `pessoas` e são compartilhados por meio de tabelas de ligação explícitas: `colaboradores_enderecos`, `fornecedores_enderecos` e `clientes_enderecos`. A localização é normalizada em `paises → ufs → cidades`; o endereço referencia somente a cidade, da qual UF e país são obtidos. As views `vw_colaborador_endereco`, `vw_fornecedor_endereco` e `vw_cliente_endereco` entregam a leitura completa sem expor IDs internos.

### Producao

Schema `producao`. Um `nucleo` é o local físico onde um ou mais `galpao` (galpão) ficam localizados; todo galpão pertence a exatamente um núcleo.

```text
[nucleos] 1 ───< N [galpoes]
```

| Tabela | Chave interna | Identificador público | Relação |
|---|---|---|---|
| `producao.nucleos` | `id` integer | `ncl_uuid` | — |
| `producao.galpoes` | `id` integer | `glp_uuid` | `nucleo_id` → `nucleos.id` (interna, nunca exposta) |

Campos de `nucleos`:

- `nome` — único (`erro NUCLEO_NOME_DUPLICADO` se repetido).

Campos de `galpoes`:

- `nome` — nome do galpão.
- `slug` — derivado do nome (`Domain\Producao\ValueObjects\Slug`), único.
- `capacidade` — quantidade máxima de aves suportadas a cada alojamento (inteiro, > 0).
- `status` — `StatusGalpao`: `OCUPADO`, `DESOCUPADO`, `VAZIO_SANITARIO`. Todo galpão novo nasce `DESOCUPADO`.

`nucleos.id` não pode ser removido com galpão vinculado (`erro NUCLEO_EM_USO`).

## Como manter atualizado

Ao criar ou alterar uma migration no Hidra, atualizar a seção do contexto correspondente neste README no mesmo PR — não em um PR separado depois.
