---
name: codificacao-pt-br
description: Exigir português do Brasil em todo vocabulário de negócio do código e do banco — classes, métodos, variáveis, tabelas, colunas, enums, mensagens, commits e PRs. Use sempre que nomear qualquer coisa em qualquer projeto do ecossistema.
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

## Checklist final

- Toda classe, método, variável e enum de negócio está em pt-BR?
- Toda tabela e coluna de negócio no MER e na migration está em pt-BR?
- As colunas/nomes que o framework exige em inglês (`created_at`, `id`, etc.) foram mantidas em inglês, sem tradução forçada?
- Mensagem de commit e descrição de PR estão em pt-BR?
