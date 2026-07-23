# Núcleo

## O que é

Um núcleo é o local físico onde os galpões de uma granja estão localizados — o agrupamento geográfico/administrativo que organiza a estrutura produtiva. Todo galpão pertence a exatamente um núcleo; um núcleo pode ter vários galpões (ou nenhum, antes do primeiro ser cadastrado).

É pré-requisito pra cadastrar um galpão: o núcleo precisa existir antes.

## Ações disponíveis

- Criar (`demeter.nucleo.criar`) — cadastra um novo núcleo.
- Listar (`demeter.nucleo.listar`) — lista todos os núcleos cadastrados, ordenados por nome.
- Visualizar (`demeter.nucleo.visualizar`) — retorna os dados de um núcleo específico.
- Alterar (`demeter.nucleo.alterar`) — renomeia um núcleo existente.
- Remover (`demeter.nucleo.remover`) — exclui um núcleo, desde que não tenha galpão vinculado.

## Como preencher corretamente

| Campo | Obrigatório | Como preencher | Erros comuns |
|---|---|---|---|
| `nome` | sim | Nome que identifica o núcleo de forma única em todo o sistema — não existem dois núcleos com o mesmo nome, mesmo que em unidades diferentes. Use um nome que não dependa de contexto pra ser entendido (ex.: "Núcleo Sede", "Núcleo Fazenda Boa Vista"), não só "Núcleo 1". | Vazio ou só espaços → `NOME_OBRIGATORIO`. Nome já usado por outro núcleo → `NUCLEO_NOME_DUPLICADO`. |

Ao **alterar**, o próprio núcleo pode manter o nome que já tem (não conta como duplicado renomear "pro mesmo nome").

## Campos gerados automaticamente

- `ncl_uuid` — identificador público do núcleo, gerado pelo sistema no momento da criação. É o valor usado em qualquer referência ao núcleo (inclusive no cadastro de galpão) — nunca preenchido por quem consome a funcionalidade.

## Exemplo

Criar o núcleo "Núcleo Central":

Entrada:
```json
{ "nome": "Núcleo Central" }
```

Resultado:
```json
{ "ncl_uuid": "d8d1e9cb-a263-4a1c-985d-9082116a5247", "nome": "Núcleo Central" }
```

Esse `ncl_uuid` é o valor que vai no campo `ncl_uuid` ao cadastrar um galpão nesse núcleo.

Tentar remover esse núcleo depois de cadastrar um galpão nele falha com `NUCLEO_EM_USO` — é preciso remover ou realocar os galpões primeiro.

## Erros possíveis

| Código | Quando acontece |
|---|---|
| `NOME_OBRIGATORIO` | Nome não informado ou só espaços em branco. |
| `NUCLEO_NOME_DUPLICADO` | Já existe outro núcleo com esse nome. |
| `NUCLEO_NAO_ENCONTRADO` | O `ncl_uuid` informado (em visualizar/alterar/remover) não corresponde a nenhum núcleo cadastrado. |
| `NUCLEO_EM_USO` | Tentativa de remover um núcleo que ainda tem galpão vinculado. |

## Referências

- Skills: `arquitetura-ecossistema-granja`, `identificadores-internos-e-publicos`, `schema-por-contexto-de-dominio`, `entidades-recebem-value-objects`.
- Endpoints: `POST /api/v1/nucleos`, `GET /api/v1/nucleos`, `GET /api/v1/nucleos/{ncl_uuid}`, `PUT /api/v1/nucleos/{ncl_uuid}`, `DELETE /api/v1/nucleos/{ncl_uuid}`.
- Collection Postman: pasta **Demeter > Núcleo**.
