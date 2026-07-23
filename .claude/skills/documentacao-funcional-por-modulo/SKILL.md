---
name: documentacao-funcional-por-modulo
description: Documentar toda funcionalidade criada — o que faz, exemplo de uso e forma correta de preenchimento de cada campo — em docs/funcionalidades/<Modulo>/<funcionalidade>.md. Use sempre que criar ou alterar uma funcionalidade (endpoint, tela, regra de negócio) em qualquer projeto do ecossistema.
---

# Documentação funcional por módulo

## Regra

Toda funcionalidade criada ou alterada tem um documento correspondente em `docs/funcionalidades/<Modulo>/<funcionalidade>.md`, atualizado no mesmo PR que introduz a mudança. `<Modulo>` é o mesmo da skill `permissoes-modulo-funcionalidade-acao` (Demeter, Argos, Hermes, Pluto — o projeto/app onde a funcionalidade é exposta ao usuário final), `<funcionalidade>` é a entidade/área de negócio (galpao, nucleo, venda...).

Isso é documentação **funcional/de negócio**, não documentação de API — complementa, não substitui, a collection Postman (`postman-collection-por-funcionalidade`, contrato técnico HTTP) e o MER (`mer-antes-de-persistir`, modelo de dados). O público daqui é qualquer pessoa que precise entender a funcionalidade sem ler código nem coleção Postman: produto, suporte, QA, outro desenvolvedor chegando no projeto.

## Estrutura do documento

```markdown
# <Funcionalidade>

## O que é
<1-2 parágrafos: o que a funcionalidade representa no negócio, por que existe.>

## Ações disponíveis
- <Ação> (`<modulo>.<funcionalidade>.<acao>`) — <uma linha do que faz>

## Como preencher corretamente

| Campo | Obrigatório | Como preencher | Erros comuns |
|---|---|---|---|
| <campo> | sim/não | <regra de preenchimento em linguagem de negócio, não só tipo de dado> | <o que acontece se preencher errado, código do erro> |

## Campos gerados automaticamente
<campos que o sistema calcula/gera — nunca preenchidos por quem consome a funcionalidade — e como são gerados.>

## Exemplo
<um caso de uso completo e realista, com valores de entrada plausíveis e o resultado esperado.>

## Erros possíveis

| Código | Quando acontece |
|---|---|
| <CODIGO_ERRO> | <situação em linguagem simples> |

## Referências
- Skill de arquitetura: `<skill relevante>`
- Endpoint(s): `<método e rota>`
- Collection Postman: pasta `<Modulo> > <Funcionalidade>`
```

## O que "forma correta de preenchimento" significa

Não é repetir o tipo de dado (isso já está no Postman/Request). É explicar a **regra de negócio** por trás do campo — o que faz um valor ser válido de verdade, não só sintaticamente:

- Errado: "`capacidade`: integer."
- Correto: "`capacidade`: número inteiro maior que zero — representa quantas aves o galpão comporta a cada novo alojamento. Não é a capacidade histórica nem a atual, é o teto por ciclo."

## Fluxo obrigatório ao criar/alterar uma funcionalidade

1. Implementar a funcionalidade (Domain → Application → Infrastructure → Presentation).
2. Documentar/atualizar a collection Postman (contrato técnico).
3. Criar ou atualizar `docs/funcionalidades/<Modulo>/<funcionalidade>.md` com a ação nova, campos, exemplo e erros.
4. Se a funcionalidade ganhou uma ação nova (ex.: `alterar` além de `criar`), adicionar a ação na lista e cobrir suas particularidades na tabela de campos, sem duplicar o que já é comum a outras ações da mesma funcionalidade.

## Proibido

- Funcionalidade nova sem o `.md` correspondente no mesmo PR.
- Documento que só repete os parâmetros do Postman sem explicar a regra de negócio por trás.
- Exemplo genérico/fictício sem relação com dados plausíveis do domínio (ex.: `"nome": "teste"`, `"capacidade": 1`).
- Um arquivo de documentação cobrindo mais de uma funcionalidade, ou uma funcionalidade espalhada em mais de um arquivo.

## Checklist final

- Existe `docs/funcionalidades/<Modulo>/<funcionalidade>.md` cobrindo a mudança?
- Toda ação da funcionalidade está listada com o código de permissão?
- Cada campo tem a regra de negócio explicada, não só o tipo?
- Há um exemplo completo e realista?
- Os erros possíveis estão listados em linguagem simples, com o código?
