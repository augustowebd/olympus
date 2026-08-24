# Endereço

## O que é

Endereço identifica a localização de colaboradores, fornecedores e clientes. País, UF e cidade precisam formar uma hierarquia válida cadastrada pelo sistema.

## Ações disponíveis

- Criar (`demeter.endereco.criar`) — cria e vincula um endereço ao proprietário.
- Listar (`demeter.endereco.listar`) — lista os endereços vinculados.
- Visualizar, alterar e remover — mantêm um endereço pelo `end_uuid`.

## Como preencher corretamente

| Campo | Obrigatório | Como preencher | Erros comuns |
|---|---|---|---|
| cep | sim | CEP brasileiro com oito dígitos; hífen é aceito. | `CEP_INVALIDO` |
| logradouro, número, bairro | sim | Dados efetivos do local. Número pode conter texto, como `S/N`. | `CAMPO_ENDERECO_OBRIGATORIO` |
| complemento | não | Informação adicional, como bloco ou apartamento. | — |
| pais_uuid, uf_uuid, cidade_uuid | sim | UUIDs públicos da mesma localização cadastrada. | `LOCALIDADE_INVALIDA` |

## Exemplo

`POST /api/v1/colaborador/{colaborador_uuid}/enderecos` com CEP `13010-061`, Rua Barreto Leme, número `1200`, bairro Centro e UUIDs correspondentes a Campinas/SP/Brasil.

## Erros possíveis

| Código | Quando acontece |
|---|---|
| `ENDERECO_NAO_ENCONTRADO` | O `end_uuid` não existe. |
| `ENDERECO_EM_USO` | Há vínculo com colaborador, fornecedor ou cliente. |
