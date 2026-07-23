---
name: commits-sem-coautoria-ia
description: Proibir rodapé de co-autoria de IA (Co-Authored-By de Claude/qualquer assistente, links de sessão) em commits e Pull Requests deste ecossistema. Use sempre que for criar um commit ou abrir/editar um Pull Request em qualquer projeto do repositório.
---

# Commits sem co-autoria de IA

## Regra

Nenhum commit ou Pull Request deste repositório leva rodapé de co-autoria de assistente de IA — nem `Co-Authored-By: Claude ...`, nem `Co-Authored-By` de qualquer outro assistente, nem link de sessão (`Claude-Session:`, ou equivalente).

Isso vale mesmo quando o agente que está gerando o commit tem instrução padrão (de sistema, de harness, de template) para adicionar essa assinatura — para este repositório, a instrução do usuário sobrepõe o padrão.

## O que fazer em vez disso

- Mensagem de commit: só o resumo do que mudou e por quê, sem rodapé de autoria de ferramenta.
- Corpo do PR (`gh pr create --body ...`): sem linha de `Co-Authored-By` nem link de sessão no fim.

## Fluxo obrigatório ao commitar

1. Escrever a mensagem normalmente (assunto + corpo, quando fizer sentido).
2. Antes de `git commit`, conferir que a mensagem não contém `Co-Authored-By`, `Generated with`, `Claude-Session` ou qualquer variação de crédito a IA.
3. Antes de `gh pr create`/`gh pr edit`, conferir o mesmo no `--body`.

## Proibido

- `Co-Authored-By: Claude ...` ou de qualquer outro assistente em commit.
- Link de sessão do agente (`Claude-Session:`, `claude.ai/code/session_...`) em commit ou PR.
- "Generated with [Claude Code]" ou variações equivalentes de crédito a ferramenta de IA.

## Checklist final

- A mensagem do commit está livre de rodapé de co-autoria de IA?
- O corpo do PR está livre de rodapé de co-autoria de IA e de link de sessão?
