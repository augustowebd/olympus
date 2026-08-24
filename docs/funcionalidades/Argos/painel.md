# Painel

## O que é

É a tela inicial do Argos após a autenticação. Ela reúne os indicadores e
alertas da granja; enquanto as integrações não estiverem disponíveis, os
campos aparecem sem valores.

## Ações disponíveis

- Sair (`argos.autenticacao.sair`) — encerra a sessão atual e volta à tela de entrada.

## Como preencher corretamente

Esta tela não possui campos de preenchimento.

## Campos gerados automaticamente

Os indicadores de produção, estoque, pedidos e faturamento serão preenchidos
pelas integrações do Hidra quando essas funcionalidades forem disponibilizadas.

## Exemplo

Após entrar como Administrador, o usuário vê o Painel geral e pode selecionar
Sair para encerrar sua sessão com segurança.

## Erros possíveis

Não há erros de preenchimento nesta tela.

## Referências

- Endpoint: `POST /sair`
- Funcionalidade relacionada: `Argos > Autenticação`
