---
name: padrao-visual-campos
description: Aplicar o padrão visual de campos de formulário do Argos, incluindo obrigatoriedade, validade, invalidez durante a edição e erro retornado pelo servidor. Use ao criar ou alterar inputs, selects, textareas ou formulários.
---

# Padrão visual de campos

## Regras obrigatórias

- Não usar asterisco para indicar obrigatoriedade.
- Usar uma barra interna esquerda de 4px nos campos obrigatórios.
- Exibir o estado vazio obrigatório em vermelho `#ff0000`.
- Exibir o estado válido em verde `#428765` somente enquanto o controle
  estiver em foco.
- Ao perder o foco com conteúdo válido, voltar para a borda e as cores padrão
  do formulário.
- Exibir o estado preenchido, mas inválido e em foco, com barra laranja e
  borda cinza.
- Exibir o estado inválido após perder o foco, ou após erro do servidor, com
  barra e borda laranja.
- Manter a borda de foco primária; no campo válido, combiná-la com a barra
  verde.

## Implementação

1. Marcar o controle obrigatório com `required` e com a classe do contêiner
   `campo--obrigatorio`.
2. Declarar as restrições nativas adequadas: `type`, `minlength`, `maxlength`,
   `pattern`, `min` e `max`, conforme o caso.
3. Incluir `placeholder` nos controles em que o seletor
   `:placeholder-shown` for usado.
4. Ao receber erro de validação do servidor, acrescentar `campo--invalido` ao
   contêiner e associar a mensagem ao campo com `role="alert"`.
5. Repetir as mesmas regras no servidor. A validação HTML melhora a interação,
   mas não substitui a validação do backend.

```css
:root {
    --danger-500: #ff0000;
    --success-500: #428765;
    --warning-500: oklch(65% 0.09 85);
    --warning-700: oklch(45% 0.08 85);
}

.campo--obrigatorio input {
    padding-left: 18px;
    box-shadow: inset 4px 0 0 var(--danger-500);
}

.campo--obrigatorio input:valid {
    box-shadow: none;
}

.campo--obrigatorio input:valid:focus {
    box-shadow: inset 4px 0 0 var(--success-500), 0 0 0 3px var(--primary-100);
}

.campo--obrigatorio input:invalid:not(:placeholder-shown):focus {
    border-color: var(--border-default);
    box-shadow: inset 4px 0 0 var(--warning-500);
}

.campo--obrigatorio input:invalid:not(:placeholder-shown):not(:focus),
.campo--invalido input {
    border-color: var(--warning-700);
    box-shadow: inset 4px 0 0 var(--warning-500);
}
```

Adaptar os seletores para `select` e `textarea` quando aplicável. Não usar
JavaScript para estados que CSS e a validação nativa já expressam.
