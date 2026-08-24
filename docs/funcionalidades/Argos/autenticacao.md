# Autenticação

## O que é

Controla o acesso ao Argos. Administradores e colaboradores com ao menos uma
permissão `argos.*` podem entrar; fornecedor e cliente não podem.

## Como acessar

Informar `username` e senha. O Argos encaminha os dados ao Hidra e mantém o
token retornado somente na sessão do servidor.

| Campo | Obrigatório | Como preencher |
|---|---|---|
| Usuário | Sim | Use `admin` para o administrador inicial ou o e-mail do colaborador. Deve ter de 4 a 255 caracteres. |
| Senha | Sim | Use de 4 a 32 caracteres, contendo pelo menos uma letra e um número. |

O administrador inicial é `admin` com a senha inicial `Qaz123`.

## Erros possíveis

| Código | Quando acontece |
|---|---|
| `CREDENCIAIS_INVALIDAS` | Usuário ou senha não conferem. |
| `ACESSO_ARGOS_NEGADO` | O usuário não é administrador nem colaborador com permissão Argos. |
| `422` | Usuário ou senha não atende às regras de preenchimento. |
