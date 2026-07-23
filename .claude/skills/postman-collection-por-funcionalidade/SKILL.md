---
name: postman-collection-por-funcionalidade
description: Criar e/ou atualizar a collection Postman do Hidra sempre que um endpoint novo ou alterado for criado, documentando o que faz, parâmetros, exemplos de request/response e permissão exigida. Use ao criar, alterar ou remover qualquer rota/controller em Presentation/Http.
---

# Collection Postman por funcionalidade

## Regra

Todo endpoint criado, alterado ou removido no Hidra tem sua entrada correspondente criada/atualizada/removida na collection Postman, **no mesmo PR** que introduz a mudança. Endpoint sem request documentada na collection é funcionalidade que ninguém consegue testar sem ler o código-fonte primeiro — trabalho incompleto.

## Onde fica

- Collection: `docs/postman/olympus.postman_collection.json` (Postman Collection Format v2.1).
- Environment: `docs/postman/olympus.postman_environment.json` — variáveis `base_url`, `token`, e demais IDs de exemplo reaproveitados nos requests.

Uma collection só, organizada em pastas seguindo a mesma hierarquia da skill `permissoes-modulo-funcionalidade-acao`:

```text
Olympus (collection)
└── Demeter (pasta = módulo)
    └── Colaborador (pasta = funcionalidade)
        ├── Criar colaborador (request = ação)
        ├── Alterar colaborador
        ├── Visualizar colaborador
        ├── Listar colaboradores
        ├── Remover colaborador
        ├── Ativar colaborador
        └── Desativar colaborador
```

## O que cada request documenta

Na aba de descrição do request (campo `description` do JSON), em Markdown:

- **O que faz**: uma frase do efeito de negócio, não da implementação técnica.
- **Permissão exigida**: o código do enum `Permissao` (ex.: `demeter.colaborador.criar`).
- **Parâmetros**: path, query e body — nome, tipo, obrigatório/opcional, significado. Body em JSON usa o `Schema`/exemplo real, não descrição solta.
- **Respostas de exemplo**: pelo menos um sucesso (`saved responses` do Postman) e um erro de validação/negócio, com o código de erro estável (ex.: `VENDA_SEM_ITENS`) — não só o happy path.
- **Observações relevantes**: idempotência, paginação, rate limit, efeitos colaterais (dispara e-mail, fila, etc.) quando existirem.

Requests usam `{{base_url}}` e `{{token}}` do environment — nunca URL ou token fixo no request.

## Fluxo obrigatório ao criar/alterar um endpoint

1. Implementar o endpoint (Presentation/Http/Controllers + Requests + Resources).
2. Localizar a pasta módulo/funcionalidade correspondente na collection; criar se não existir.
3. Criar ou atualizar o request: método, URL com `{{base_url}}`, headers, body de exemplo, descrição completa (ver seção acima).
4. Executar o request contra o ambiente local (`docker-compose`) e salvar pelo menos um `Saved Response` de sucesso e um de erro.
5. Exportar a collection atualizada por cima do arquivo em `docs/postman/olympus.postman_collection.json` (Postman: `...` na collection → `Export` → Collection v2.1).
6. Se o endpoint foi removido, remover o request correspondente — não deixar request morto apontando pra rota inexistente.

## Proibido

- Endpoint novo sem request correspondente no mesmo PR.
- Request sem descrição (o campo `description` vazio não é aceitável).
- URL ou token hardcoded em vez de variável de environment.
- Exemplo de resposta só do caminho feliz, sem nenhum caso de erro.
- Duplicar a mesma funcionalidade em pastas de módulos diferentes — a pasta é a do módulo dono da tela que consome (ver `permissoes-modulo-funcionalidade-acao`), não onde for conveniente.

## Checklist final

- Toda rota nova/alterada tem request criado/atualizado na collection, no mesmo PR?
- O request está na pasta `Módulo/Funcionalidade` correta?
- A descrição cobre o quê, parâmetros, permissão exigida e observações relevantes?
- Há pelo menos um exemplo de sucesso e um de erro salvos?
- URL e auth usam variáveis de environment, não valores fixos?
- Rotas removidas tiveram o request correspondente removido?
