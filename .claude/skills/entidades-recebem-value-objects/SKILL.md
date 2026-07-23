---
name: entidades-recebem-value-objects
description: Métodos de fábrica de entidades de domínio recebem Value Objects já construídos, nunca primitivos que a entidade valida/converte por dentro. Use sempre que criar ou alterar um método `registrar`/construtor de entidade, um caso de uso que a invoca, ou um repositório que a reconstitui a partir de persistência.
---

# Entidades recebem Value Objects, não primitivos

## Regra

Se um campo da entidade tem Value Object (`GalpaoId`, `Capacidade`, `Nome`, `Slug`...), o método de fábrica da entidade (`registrar`, `reconstituir`, etc.) recebe o Value Object já construído — nunca a string/int primitivo que o VO envolve, pra depois criar o VO por dentro.

Se dois parâmetros já chegam como VO (`GalpaoId $id`, `Capacidade $capacidade`) e um terceiro chega como `string $nome` só porque "é mais simples", a assinatura vira inconsistente e a entidade acumula uma segunda validação que já deveria estar centralizada no VO — a mesma duplicação de invariante que a skill de Value Objects resolve, só que deslocada pra fronteira errada.

## Quem constrói o Value Object

A camada que **recebe dado primitivo/externo** o converte antes de entregar pro domínio:

- **Application** (caso de uso): converte o DTO (primitivos vindos da Presentation) em Value Objects antes de chamar a entidade.
- **Infrastructure** (repositório, ao reconstruir a partir de persistência): converte a coluna/atributo do model Eloquent em Value Object antes de chamar a entidade.

A entidade em si só aceita e compõe Value Objects — nunca valida um primitivo internamente pra depois embrulhar.

## Exemplo

Errado — `Galpao` recebe `string $nome` e valida por dentro:

```php
final class Galpao
{
    public static function registrar(GalpaoId $id, string $nome, Capacidade $capacidade, NucleoId $nucleoId): self
    {
        $nome = Nome::deTexto($nome); // validação escondida dentro da entidade
        return new self($id, $nome, Slug::deTexto($nome->valor()), $capacidade, $nucleoId, StatusGalpao::DESOCUPADO);
    }
}
```

Correto:

```php
final class Galpao
{
    public static function registrar(GalpaoId $id, Nome $nome, Capacidade $capacidade, NucleoId $nucleoId): self
    {
        return new self($id, $nome, Slug::deTexto($nome->valor()), $capacidade, $nucleoId, StatusGalpao::DESOCUPADO);
    }
}
```

```php
// Application/Producao/UseCases/RegistrarGalpao.php
$galpao = Galpao::registrar(
    id: GalpaoId::fromString($this->geradorIdentificador->gerar()),
    nome: Nome::deTexto($dto->nome),
    capacidade: Capacidade::deAves($dto->capacidade),
    nucleoId: $nucleoId,
);
```

Reconstituição a partir de persistência segue a mesma regra — a Infrastructure converte antes de chamar a entidade:

```php
// EloquentNucleoRepository::obterPorId
return Nucleo::registrar(
    id: NucleoId::fromString($model->ncl_uuid),
    nome: Nome::deTexto($model->nome),
);
```

## Por que

- **DRY de verdade**: a invariante do VO mora num lugar só; a assinatura do método deixa explícito o que já está garantido antes de entrar — não é preciso ler o corpo da entidade pra saber se `$nome` pode chegar vazio.
- **Assinatura autoexplicativa**: `registrar(GalpaoId, Nome, Capacidade, NucleoId)` documenta o contrato sozinho; `registrar(GalpaoId, string, Capacidade, NucleoId)` esconde uma regra de validação atrás daquele `string`.
- **Falha mais cedo, no lugar certo**: se a Application constrói o VO antes de montar qualquer outra coisa, uma falha de validação não deixa efeito colateral parcial.

## Proibido

- Método de fábrica de entidade com um parâmetro Value Object e outro primitivo equivalente, quando o VO já existe pro conceito.
- Construir Value Object dentro do construtor/fábrica da própria entidade a partir de primitivo recebido.
- Validação de invariante de VO duplicada fora do VO (ex.: checar `trim($nome) === ''` no caso de uso E dentro do VO/entidade).

## Checklist final

- Todo parâmetro da fábrica que tem Value Object correspondente é recebido como VO, não como primitivo?
- O VO é construído na Application (a partir do DTO) ou na Infrastructure (a partir da persistência), nunca dentro da entidade?
- A assinatura do método de fábrica deixa claro, sem ler o corpo, o que já está validado?
