# Olympus

Monorepo do ERP da granja. Cada pasta é um sistema Laravel independente, todos conversando com a
**Hidra**, que centraliza a regra de negócio e os dados.

> Hidra   - API responsável por prover funcionalidades para todos os demais sistemas

> Argos   - Backoffice / sistema desktop consumidor da Hidra

> Demeter - App com funcionalidades para gerir tarefas cotidianas da granja

> Hermes  - App do entregador de encomendas

> Pluto   - PDV para vendas

Só **Hidra** e **Argos** existem hoje. Demeter, Hermes e Pluto ainda não foram criados.

## Como acessar

```bash
docker compose up -d
```

| Sistema  | URL                     | Tem tela no navegador? |
|----------|-------------------------|-------------------------|
| Hidra    | http://localhost:8000   | Não — só API (sem `routes/web.php`) |
| Argos    | http://localhost:8001   | Sim — backoffice |
| Postgres | localhost:5432 (db `hidra`/`argos`, user/senha `olympus`) | - |
| Redis    | localhost:6379          | - |

Para explorar a API da Hidra sem UI, use a collection Postman em
`docs/postman/olympus.postman_collection.json`.

Rodando um sistema fora de Docker (dentro da pasta dele, ex. `hidra/`):

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

## Organização das pastas

```
hidra/    # API central (DDD: Domain / Application / Infrastructure / Presentation)
argos/    # Backoffice web, consome a API da Hidra
docker/   # Dockerfiles usados pelo docker-compose.yml
docs/     # Documentação do ecossistema (ver abaixo)
feedback/ # Feedbacks/anotações do time
.claude/  # Skills e regras arquiteturais obrigatórias para os agentes (Claude Code)
```

Dentro de cada sistema (`hidra/`, `argos/`) as tabelas do banco são separadas por **schema
Postgres por contexto de domínio** (`pessoas`, `producao`, etc — não é multi-tenant, é só
organização por bounded context do DDD). Tabelas de infraestrutura do Laravel ficam em `public`.

## Documentação (`docs/`)

- `docs/database/erd.dbml` — MER (modelo de dados) de todos os projetos.
- `docs/funcionalidades/<Sistema>/` — documentação funcional de cada feature: o que faz, exemplo
  de uso, como preencher cada campo.
- `docs/postman/olympus.postman_collection.json` — collection Postman dos endpoints da Hidra.
- `docs/design-system/` — componentes e tokens visuais usados no Argos.

## Regras do ecossistema

As regras arquiteturais obrigatórias (onde fica regra de negócio, DDD por camada, PT-BR no
domínio, identificadores internos/públicos, schema por contexto, fluxo de PR, etc.) estão
versionadas como skills em `.claude/skills/` e se aplicam a todos os projetos deste monorepo.
