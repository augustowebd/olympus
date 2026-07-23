---
name: fluxo-pull-request
description: Fluxo obrigatório de versionamento via Pull Request para o ecossistema (repositório github.com/augustowebd/olympus). Use sempre que for commitar, enviar ou publicar qualquer alteração de código — nunca commitar/push direto na branch main, que está protegida.
---

# Fluxo de Pull Request

## Regra

A branch `main` é protegida no GitHub (`enforce_admins` ativo, push direto bloqueado). Toda alteração — mesmo pequena, mesmo de um agente — entra por Pull Request. Não existe exceção de "é só uma linha".

## Fluxo obrigatório

1. Criar uma branch a partir de `main` com nome descritivo:
   ```bash
   git checkout main && git pull
   git checkout -b <tipo>/<descricao-curta>
   ```
   Prefixos de tipo: `feat/`, `fix/`, `chore/`, `docs/`, `refactor/`.

2. Commitar o trabalho na branch (nunca em `main`).

3. Rodar a suíte de testes do(s) projeto(s) alterados antes de abrir o PR (ver skill `cobertura-testes-unitarios`).

4. Enviar a branch e abrir o PR:
   ```bash
   git push -u origin <branch>
   gh pr create --title "..." --body "..."
   ```

5. Nunca fazer merge local + push para `main`. O merge acontece pelo PR (`gh pr merge` ou pela UI do GitHub), após review quando houver.

## Proibido

- `git push origin main` (será rejeitado pela proteção, mas nem tente).
- `git commit` diretamente em `main` mesmo que local.
- `git push --force` em `main`.
- Merge de PR sem a suíte de testes passando.

## Se pedirem para "só subir direto"

Responda que `main` é protegida e a mudança precisa ir por PR; crie a branch e o PR em vez de tentar contornar a proteção.

## Checklist antes de abrir o PR

- Está numa branch, não em `main`?
- Testes relevantes passam?
- Título e descrição do PR explicam o "porquê", não só o "o quê"?
