# Galpão

## O que é

Um galpão é a estrutura física de alojamento de aves usada na produção de ovos. Todo galpão pertence a um núcleo (o local onde está fisicamente instalado) e tem uma capacidade máxima de aves por ciclo de alojamento.

O status do galpão reflete se ele está em uso, vazio ou em vazio sanitário (período de descanso/higienização entre lotes) — isso é controlado pelo próprio sistema ao longo do ciclo produtivo, não é escolhido livremente no cadastro.

## Ações disponíveis

- Criar (`demeter.galpao.criar`) — cadastra um novo galpão vinculado a um núcleo já existente.

Só a criação está implementada até aqui — visualizar, listar, alterar, remover e ativar/desativar ainda não existem (ver skill `permissoes-modulo-funcionalidade-acao` pro vocabulário de ações quando forem implementadas).

## Como preencher corretamente

| Campo | Obrigatório | Como preencher | Erros comuns |
|---|---|---|---|
| `nome` | sim | Nome que identifica o galpão dentro do núcleo. Vira a base do `slug` gerado automaticamente — evite nomes idênticos entre galpões, mesmo de núcleos diferentes, já que o `slug` derivado precisa ser único no sistema todo. | Vazio ou só espaços → `NOME_OBRIGATORIO`. Nome que gera o mesmo slug de um galpão já existente → `SLUG_DUPLICADO`. |
| `capacidade` | sim | Número inteiro maior que zero — quantidade **máxima** de aves que o galpão suporta a cada novo alojamento (o teto por ciclo, não a ocupação atual nem um histórico). | Zero ou negativo → `CAPACIDADE_INVALIDA`. |
| `ncl_uuid` | sim | O identificador público (`ncl_uuid`) de um núcleo já cadastrado — obtido ao criar/listar o núcleo (ver `docs/funcionalidades/Demeter/nucleo.md`). O núcleo precisa existir antes do galpão. | Núcleo inexistente → `NUCLEO_NAO_ENCONTRADO`. |

## Campos gerados automaticamente

- `glp_uuid` — identificador público do galpão, gerado pelo sistema.
- `slug` — derivado automaticamente do `nome` (minúsculo, sem acento, espaços viram hífen). Não é um campo de entrada.
- `status` — todo galpão nasce com status `DESOCUPADO`. Muda pra `OCUPADO` ou `VAZIO_SANITARIO` conforme o ciclo produtivo avança (fora do escopo desta funcionalidade de criação).

## Exemplo

Depois de ter o núcleo "Núcleo Central" (`ncl_uuid`: `d8d1e9cb-a263-4a1c-985d-9082116a5247`), criar o galpão "Galpão Norte 01" com capacidade pra 5.000 aves:

Entrada:
```json
{
  "nome": "Galpão Norte 01",
  "capacidade": 5000,
  "ncl_uuid": "d8d1e9cb-a263-4a1c-985d-9082116a5247"
}
```

Resultado:
```json
{
  "glp_uuid": "ca6f0725-ca13-491e-8a22-498a5f588706",
  "nome": "Galpão Norte 01",
  "slug": "galpao-norte-01",
  "capacidade": 5000,
  "ncl_uuid": "d8d1e9cb-a263-4a1c-985d-9082116a5247",
  "status": "DESOCUPADO"
}
```

## Erros possíveis

| Código | Quando acontece |
|---|---|
| `NOME_OBRIGATORIO` | Nome não informado ou só espaços em branco. |
| `SLUG_INVALIDO` | O nome não gera nenhum caractere alfanumérico aproveitável pro slug (situação rara, geralmente nome só com símbolos). |
| `SLUG_DUPLICADO` | Já existe um galpão cujo nome gera o mesmo slug. |
| `CAPACIDADE_INVALIDA` | Capacidade zero, negativa, ou não informada. |
| `NUCLEO_NAO_ENCONTRADO` | O `ncl_uuid` informado não corresponde a nenhum núcleo cadastrado. |

## Referências

- Skills: `arquitetura-ecossistema-granja`, `identificadores-internos-e-publicos`, `schema-por-contexto-de-dominio`, `entidades-recebem-value-objects`.
- Endpoint: `POST /api/v1/galpoes`.
- Collection Postman: pasta **Demeter > Galpão**.
