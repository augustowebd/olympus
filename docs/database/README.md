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
- Identificadores: UUID como chave primária das entidades de domínio.
- Enums de status/tipo: coluna `string` com os valores do enum de domínio (ex.: `StatusVenda`), nunca inteiro mágico.
- Toda tabela de entidade de domínio tem `created_at`/`updated_at`; `deleted_at` (soft delete) só quando o domínio precisar de histórico, não por padrão.
- Nome de tabela no plural em snake_case, alinhado ao nome do agregado (`vendas`, `itens_venda`).

## Diagramas

Ainda não há contexto de domínio implementado — a primeira migration real gera a primeira seção aqui (diagrama + dicionário do contexto correspondente).

## Como manter atualizado

Ao criar ou alterar uma migration no Hidra, atualizar a seção do contexto correspondente neste README no mesmo PR — não em um PR separado depois.
