# Colaborador

## O que é

Tela de cadastro de colaboradores no grupo Granja do Argos. Reúne identificação,
endereço, filiação, documentação, acesso, contratação e dados familiares em um
único envio.

## Ações disponíveis

- Listar (`argos.colaborador.listar`) — abre a tela de colaboradores.
- Criar (`argos.colaborador.criar`) — registrará o colaborador quando a API do Hidra for disponibilizada.

## Como preencher corretamente

| Campo | Obrigatório | Como preencher | Erros comuns |
|---|---|---|---|
| Matrícula | Sim | Código interno único do colaborador. | Repetir uma matrícula existente. |
| Nome completo | Sim | Nome civil completo. | Usar apelido. |
| Documento | Sim | Escolha o tipo e informe o número correspondente. | Informar número de outro documento. |
| E-mail | Sim | E-mail que será usado para entrar no Argos. | Informar e-mail já usado. |
| Salário | Sim | Valor mensal em reais. | Informar valor negativo. |

## Campos gerados automaticamente

A senha inicial será gerada pelo Hidra ao salvar e poderá ser copiada uma vez
para envio ao colaborador. Salário-família depende da elegibilidade retornada
pelo Hidra após o cadastro dos filhos.

## Exemplo

Cadastre a matrícula `2026001`, o nome completo do colaborador e seu e-mail.
Após registrar filhos, o Hidra informará se salário-família pode ser marcado.

## Erros possíveis

| Código | Quando acontece |
|---|---|
| `MATRICULA_DUPLICADA` | A matrícula já pertence a outro colaborador. |
| `EMAIL_EM_USO` | O e-mail já possui acesso. |

## Referências

- Funcionalidade relacionada: Argos > Autenticação
- Endereço: módulo Pessoas > Endereços
