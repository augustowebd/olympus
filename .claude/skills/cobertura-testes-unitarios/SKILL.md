---
name: cobertura-testes-unitarios
description: Garantir cobertura de testes unitários para todo código gerado ou alterado nos projetos do ecossistema (Hidra, Argos, Demeter, Hermes, Pluto). Use sempre que criar, alterar ou refatorar uma classe com lógica (Entity, Value Object, caso de uso, serviço, controller, componente) — antes de considerar a tarefa concluída.
---

# Cobertura de Testes Unitários

## Regra

Nenhuma lógica nova ou alterada fica sem teste correspondente. Código gerado sem teste é trabalho incompleto, não uma etapa posterior.

Isento de teste dedicado:

- getters/setters triviais sem validação;
- DTOs e Value Objects sem invariantes (apenas dados);
- classes de configuração/constantes;
- código gerado por scaffold do framework não alterado.

## O que testar, por camada (Hidra)

- **Domain** (Entities, Value Objects, Enums, exceções): teste unitário puro, sem Laravel, sem banco, sem HTTP. Cobrir invariantes e casos de erro (ex.: `Dinheiro` não aceita negativo, `Venda` sem itens lança `VendaSemItensException`).
- **Application** (casos de uso): teste unitário com dependências (`Repository`, `UnidadeDeTrabalho`, `Relogio`, `GeradorIdentificador`) substituídas por doubles/fakes — nunca a implementação real de infraestrutura.
- **Infrastructure** (repositórios Eloquent, integrações): teste de integração (banco em memória/sqlite, `RefreshDatabase`) verificando persistência e mapeamento, não regra de negócio.
- **Presentation** (controllers, requests, resources): teste de feature/endpoint (`assertStatus`, `assertJsonStructure`), validação de contrato HTTP e códigos de erro — não reexecutar regra de domínio.

## O que testar nos clientes (Argos, Demeter, Hermes, Pluto)

- Testes de componente/apresentação e de tratamento de resposta do cliente HTTP (sucesso, erro, timeout).
- Nunca reescrever nos clientes o teste da regra que já é testada no Hidra.

## Convenções

- Nomeie o teste pelo comportamento, não pela implementação: `test_lanca_excecao_quando_venda_sem_itens`, não `test_construtor`.
- Um teste, uma asserção de comportamento — arranjo (`Arrange`) / ação (`Act`) / verificação (`Assert`) claros, sem lógica condicional dentro do teste.
- Testes de domínio não usam mocks de framework (Eloquent, DB, Http) — se precisar, a classe está na camada errada.
- Erros de negócio são verificados pelo código do enum (`CodigoErroVenda::...`), nunca por texto de mensagem.

## Fluxo obrigatório ao gerar código

1. Implementar a classe/método.
2. Escrever o teste que cobre o caminho feliz e os casos de erro/invariante conhecidos.
3. Rodar a suíte do projeto (`php artisan test` / `npm test`) antes de encerrar a tarefa.
4. Se um teste existente quebrar por causa da mudança, corrigir o teste ou a implementação — nunca apagar o teste para fazer passar.

## Checklist final

- Toda classe com lógica tem teste correspondente?
- Domain testado sem Laravel/Eloquent/HTTP?
- Casos de uso testados com doubles das dependências, não implementações reais?
- Casos de erro e invariantes cobertos, não só o caminho feliz?
- A suíte completa passa antes de finalizar?
