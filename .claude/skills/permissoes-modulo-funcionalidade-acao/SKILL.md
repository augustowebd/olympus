---
name: permissoes-modulo-funcionalidade-acao
description: Mapear toda funcionalidade criada em Módulo → Funcionalidade → Ação para alimentar o sistema de permissões (por perfil e/ou granular). Use sempre que criar, alterar ou remover um caso de uso, endpoint ou tela que precise de controle de acesso, em qualquer projeto do ecossistema.
---

# Permissões: Módulo → Funcionalidade → Ação

## Regra

Toda funcionalidade nova é mapeada em três níveis antes (ou junto) de ser implementada:

```text
Módulo → Funcionalidade → Ação
```

- **Módulo**: o projeto/app onde a funcionalidade é exposta ao usuário (`Demeter`, `Argos`, `Hermes`, `Pluto`).
- **Funcionalidade**: a entidade ou área de negócio dentro do módulo (`colaborador`, `venda`, `estoque`).
- **Ação**: o verbo específico sobre a funcionalidade.

```text
Demeter -> colaborador -> criar
Demeter -> colaborador -> alterar
Demeter -> colaborador -> visualizar
Demeter -> colaborador -> remover
Demeter -> colaborador -> ativar
Demeter -> colaborador -> desativar
```

Essa tripla é o que autoriza — por perfil (conjunto de triplas) e/ou de forma granular (uma triplla isolada concedida a um usuário específico).

## Vocabulário de ações

Ações canônicas, reutilize antes de inventar uma nova:

- `criar`
- `visualizar` (ver um registro)
- `listar` (ver a coleção/grid)
- `alterar`
- `remover`
- `ativar`
- `desativar`

`ativar` e `desativar` são ações separadas, nunca uma só `ativar/desativar` — perfis podem ter permissão pra uma sem a outra. Ações de negócio específicas (`aprovar`, `cancelar`, `exportar`, `confirmar`) são permitidas quando o verbo genérico não descreve a operação — não force tudo em CRUD.

## Onde vive o código

Autorização é regra de negócio: decidida e aplicada sempre no Hidra (ver skill `arquitetura-ecossistema-granja`), nunca só escondendo botão no cliente.

Cada tripla vira um caso do enum central de permissões:

```php
<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enums;

enum Permissao: string
{
    case DEMETER_COLABORADOR_CRIAR = 'demeter.colaborador.criar';
    case DEMETER_COLABORADOR_ALTERAR = 'demeter.colaborador.alterar';
    case DEMETER_COLABORADOR_VISUALIZAR = 'demeter.colaborador.visualizar';
    case DEMETER_COLABORADOR_LISTAR = 'demeter.colaborador.listar';
    case DEMETER_COLABORADOR_REMOVER = 'demeter.colaborador.remover';
    case DEMETER_COLABORADOR_ATIVAR = 'demeter.colaborador.ativar';
    case DEMETER_COLABORADOR_DESATIVAR = 'demeter.colaborador.desativar';
}
```

- Nome do case: `MODULO_FUNCIONALIDADE_ACAO`, tudo maiúsculo.
- Valor do case: `modulo.funcionalidade.acao`, tudo minúsculo, separado por ponto — é o código estável persistido/transmitido (perfil ↔ permissão, claim de token, etc.), nunca o nome do case.
- Um módulo/funcionalidade/ação sem verbo genérico correspondente ainda segue o padrão: `pluto.venda.aprovar`, `hermes.entrega.confirmar`.

## Fluxo obrigatório ao criar uma funcionalidade

1. Identificar módulo, funcionalidade e a(s) ação(ões) que a funcionalidade expõe.
2. Verificar se a tripla já existe no enum `Permissao` — reusar, nunca duplicar com nome diferente para o mesmo significado.
3. Adicionar os casos que faltam.
4. O caso de uso/endpoint correspondente exige a permissão antes de executar (gate de autorização no Hidra, não no cliente).
5. Perfis (roles) e permissões concedidas a usuários específicos são combinações dessas triplas — não crie um mecanismo de autorização paralelo por funcionalidade.

## Proibido

- Checar permissão comparando string solta (`if ($acao === 'criar')`) em vez do case do enum.
- Criar ação nova quando uma ação canônica já cobre o caso.
- Autorizar só no cliente (esconder botão) sem o Hidra também negar a ação.
- Misturar módulo e funcionalidade num único nível (ex.: `colaborador.demeter.criar` — a ordem é sempre módulo → funcionalidade → ação).

## Checklist final

- A funcionalidade está mapeada como módulo → funcionalidade → ação?
- A tripla já existe no enum `Permissao` antes de criar uma nova?
- A ação usa o vocabulário canônico, ou há justificativa pra um verbo específico?
- O Hidra valida a permissão no caso de uso/endpoint, não só a UI do cliente?
