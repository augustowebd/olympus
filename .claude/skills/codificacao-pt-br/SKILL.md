---
name: codificacao-pt-br
description: Exigir português do Brasil em todo vocabulário de negócio do código e do banco — classes, métodos, variáveis, tabelas, colunas, enums, mensagens, commits e PRs — além de fuso horário America/Sao_Paulo e moeda sempre Real (BRL). Use sempre que nomear qualquer coisa, configurar timezone/locale, ou lidar com data/hora e valores monetários em qualquer projeto do ecossistema.
---

# Codificação em pt-BR

## Regra

Todo nome que carrega significado de negócio é em português do Brasil, sem exceção: classes, interfaces, métodos, propriedades, variáveis, parâmetros, tabelas, colunas, índices nomeados, enums e seus casos, chaves de configuração de domínio, mensagens de erro/validação, nomes de rota/endpoint de negócio, mensagens de commit e descrição de PR.

Já é o padrão em todo o código existente — `Venda`, `ItemVenda`, `StatusVenda`, `Dinheiro`, `Quantidade`, `Colaborador`, `Fornecedor`, `Cliente`, `RegistrarVenda`, `colaboradores`, `fornecedores` — esta skill só torna a regra explícita e evita regressão pro inglês.

## O que fica em inglês (não traduzir)

- Palavras reservadas e sintaxe da linguagem/framework: `class`, `public`, `function`, `interface`, `enum`, `extends`, `implements`, `readonly`, `static`.
- Nomes que o framework exige em inglês: `id`, `created_at`, `updated_at`, `deleted_at`, `password`, `email`, `remember_token` (colunas/convenções do Laravel), métodos de contrato de interfaces do framework (`toArray`, `rules`, `authorize`, `up`, `down`, `boot`).
- Nomes de pacotes/bibliotecas de terceiros e o vocabulário técnico deles (`Illuminate\Http\Request`, `Str::uuid()`).
- Termos técnicos sem tradução natural consolidada no time (`middleware`, `token`, `slug`, `cache`) — mantenha o termo técnico, não force uma tradução forçada que ninguém usa.

A linha de corte: **vocabulário de negócio** (o que a granja, o colaborador, o fornecedor, a venda, o lote fazem e são) é pt-BR. **Vocabulário de infraestrutura/framework** (como o código é escrito, não o que ele representa) segue a convenção da linguagem/framework, que é inglês.

## Exemplos

Correto:

```php
final class Venda
{
    public function registrar(): void { /* ... */ }
    public function estaAberta(): bool { /* ... */ }
}

enum StatusVenda: string
{
    case ABERTA = 'ABERTA';
    case CANCELADA = 'CANCELADA';
}
```

```php
Schema::create('itens_venda', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('venda_id')->constrained('vendas');
    $table->integer('quantidade');
    $table->integer('valor_unitario_centavos');
    $table->timestamps(); // created_at/updated_at: convenção do framework, fica em inglês
});
```

Incorreto:

```php
final class Sale
{
    public function register(): void { /* ... */ }
}
```

```php
Schema::create('sale_items', function (Blueprint $table) {
    $table->integer('quantity');
});
```

## Fuso horário e localidade

- Timezone da aplicação: `America/Sao_Paulo` — `config/app.php` (`'timezone' => 'America/Sao_Paulo'`) em todo projeto Laravel do ecossistema, nunca o `UTC` padrão do Laravel.
- Locale: `pt_BR` — `APP_LOCALE=pt_BR`, `APP_FALLBACK_LOCALE=pt_BR`, `APP_FAKER_LOCALE=pt_BR` no `.env`/`.env.example`.
- A hora "de agora" usada pelo domínio (contrato `Relogio` — ver skill `arquitetura-ecossistema-granja`) reflete o fuso configurado da aplicação, não UTC arbitrário.
- Exibição de data ao usuário: `dd/mm/aaaa`, nunca `mm/dd/aaaa` (já documentado no design system — `formatDatePt`, `docs/design-system/README.md`).

## Moeda

- Moeda oficial do sistema é o Real (BRL) — sem suporte a múltiplas moedas enquanto não for pedido (YAGNI).
- Valores monetários continuam inteiros em centavos (Value Object `Dinheiro`, ver skill `arquitetura-ecossistema-granja`), nunca `float`.
- Formatação exibida ao usuário: `R$` fora do campo, separador de milhar `.`, decimal `,` (`R$ 1.234,56`) — nunca `$`, `USD` ou ponto decimal americano. No cliente, usa `formatCurrencyPt` (design system), nunca `Intl.NumberFormat('en-US', ...)` ou equivalente.

## Onde vale

- Domain, Application, Infrastructure, Presentation (Hidra) — todas as camadas.
- Migrations, MER em DBML (`docs/database/erd.dbml`), collection Postman (`docs/postman`) — nomes de tabela, campo, pasta e request.
- Clientes (Argos, Demeter, Hermes, Pluto) — componentes, variáveis de estado, rotas de UI.
- Mensagens de commit e descrição de Pull Request.

## Proibido

- Misturar idioma no mesmo conceito (`class Venda { public function cancelOrder() {} }`).
- Traduzir literalmente convenção de framework que deveria ficar em inglês (`created_at` virar `criado_em` quebra o Eloquent sem necessidade).
- Nome de tabela/coluna em inglês pra entidade de domínio (`sales`, `quantity`, `unit_price`).
- Commit ou PR em inglês.
- Timezone `UTC` (padrão do Laravel) ou qualquer outro diferente de `America/Sao_Paulo` num projeto novo.
- Valor monetário em outra moeda, símbolo `$`/`USD`, ou formatação de data/número americana visível ao usuário.

## Checklist final

- Toda classe, método, variável e enum de negócio está em pt-BR?
- Toda tabela e coluna de negócio no MER e na migration está em pt-BR?
- As colunas/nomes que o framework exige em inglês (`created_at`, `id`, etc.) foram mantidas em inglês, sem tradução forçada?
- Mensagem de commit e descrição de PR estão em pt-BR?
- `config/app.php` está com `timezone => America/Sao_Paulo` e locale `pt_BR`?
- Valor monetário é BRL, em centavos, formatado como `R$ 0.000,00`?
