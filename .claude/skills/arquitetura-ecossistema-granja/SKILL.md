---
name: arquitetura-ecossistema-granja
description: Aplicar a arquitetura obrigatória dos projetos Hidra, Argos, Farm, Hermes e Pluto. Use ao criar, alterar, revisar ou refatorar código deste ecossistema, especialmente para decidir onde ficam regras de negócio, organizar camadas DDD, consumir a API Hidra e evitar valores mágicos.
---

# Arquitetura do Ecossistema Granja

## Objetivo

Esta skill define as regras obrigatórias para geração, alteração, revisão e organização de código nos projetos:

- Hidra;
- Argos;
- Farm;
- Hermes;
- Pluto.

Antes de implementar qualquer funcionalidade:

1. Identifique o projeto.
2. Identifique o contexto de domínio.
3. Verifique se existe regra de negócio.
4. Direcione toda regra de negócio ao Hidra.
5. Escolha a camada responsável.
6. Procure contratos e implementações existentes.
7. Evite duplicações, acoplamentos e valores mágicos.
8. Crie ou atualize os testes correspondentes.

## Princípio arquitetural principal

Toda regra de negócio deve estar centralizada no Hidra.

```text
Argos, Farm, Hermes e Pluto apresentam e coletam dados.
Hidra decide, valida e executa o negócio.
```

Os projetos clientes podem controlar:

- interface;
- navegação;
- estado local;
- cache temporário;
- experiência do usuário;
- integração HTTP;
- sincronização offline limitada.

Eles não podem implementar, duplicar ou reinterpretar regras de negócio.

## Projetos

| Projeto | Tecnologia | Responsabilidade |
|---|---|---|
| Hidra | Laravel API-only | API central e regras de negócio |
| Argos | Laravel + Blade | Backoffice administrativo |
| Farm | React Native | Operações cotidianas da granja |
| Hermes | React Native | Operações de entrega |
| Pluto | Laravel Web | Ponto de venda |

## Comunicação

```text
Argos ─────┐
Farm ──────┤
Hermes ────┼──→ API Hidra ───→ Application ───→ Domain
Pluto ─────┘                         │
                                     ↓
                              Infrastructure
```

Não permitir:

```text
Cliente → banco de dados do Hidra
Cliente → outro cliente
Cliente → regra de negócio local
Cliente → alteração direta do estado oficial
```

Quando um projeto precisar de funcionalidade de outro contexto, disponibilize-a pelo Hidra.

# Estrutura dos projetos Laravel

O código próprio do sistema deve ficar em `./src`, separado da estrutura do framework.

Não use `./app` para código da aplicação.

```text
project/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── src/
├── storage/
├── tests/
├── vendor/
├── artisan
└── composer.json
```

O namespace raiz pode continuar sendo `App\`, desde que o Composer o mapeie para `src/`.

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/",
      "Database\\Factories\\": "database/factories/",
      "Database\\Seeders\\": "database/seeders/"
    }
  },
  "autoload-dev": {
    "psr-4": {
      "Tests\\": "tests/"
    }
  }
}
```

Após modificar o autoload:

```bash
composer dump-autoload
```

Todas as referências desta skill usam `src/`. Não crie classes da aplicação em `app/`.

# Hidra

## Responsabilidade

O Hidra é a API central e a fonte oficial do ecossistema.

Ele deve:

- centralizar regras de negócio;
- implementar casos de uso;
- proteger invariantes;
- aplicar autorizações;
- controlar transações;
- persistir dados;
- integrar serviços externos;
- emitir eventos;
- processar filas;
- disponibilizar APIs versionadas;
- garantir integridade e consistência.

## Restrições

Não implemente regra de negócio diretamente em:

- controllers;
- Form Requests;
- Resources;
- middlewares;
- rotas;
- jobs;
- listeners;
- commands;
- Service Providers;
- models Eloquent;
- repositories concretos;
- clientes HTTP;
- componentes de infraestrutura.

Esses elementos podem adaptar, coordenar ou executar detalhes técnicos, mas não decidir o negócio.

## Estrutura recomendada

```text
src/
├── Domain/
│   ├── Shared/
│   ├── Vendas/
│   │   ├── Entities/
│   │   ├── ValueObjects/
│   │   ├── Enums/
│   │   ├── Events/
│   │   ├── Exceptions/
│   │   ├── Services/
│   │   └── Repositories/
│   ├── Entregas/
│   ├── Producao/
│   ├── Estoque/
│   └── Pessoas/
├── Application/
│   ├── Shared/
│   │   ├── Contracts/
│   │   └── DTOs/
│   ├── Vendas/
│   │   ├── UseCases/
│   │   ├── DTOs/
│   │   └── Results/
│   └── ...
├── Infrastructure/
│   ├── Persistence/
│   ├── Integrations/
│   ├── Queue/
│   ├── Cache/
│   ├── Time/
│   ├── Identifiers/
│   └── Providers/
└── Presentation/
    └── Http/
        ├── Controllers/
        ├── Requests/
        ├── Resources/
        ├── Middleware/
        └── Exceptions/
```

## Dependências

```text
Presentation ──→ Application ──→ Domain
                      ↑
Infrastructure ───────┘
```

O domínio não depende de:

- Laravel;
- Eloquent;
- HTTP;
- banco de dados;
- filas;
- cache;
- sistema de arquivos;
- integrações externas;
- infraestrutura.

## Fluxo

```text
Request HTTP
    ↓
Form Request
    ↓
Controller
    ↓
DTO
    ↓
Caso de uso
    ↓
Entidades, Value Objects e serviços de domínio
    ↓
Contratos
    ↓
Implementações de infraestrutura
    ↓
Resource
    ↓
Response HTTP
```

```text
Presentation recebe e responde.
Application coordena.
Domain decide.
Infrastructure implementa detalhes técnicos.
```

# Exemplo por camada: registrar venda

## Estrutura

```text
src/
├── Domain/Vendas/
│   ├── Entities/Venda.php
│   ├── Entities/ItemVenda.php
│   ├── ValueObjects/VendaId.php
│   ├── ValueObjects/ProdutoId.php
│   ├── Enums/StatusVenda.php
│   ├── Enums/CodigoErroVenda.php
│   ├── Exceptions/VendaSemItensException.php
│   └── Repositories/VendaRepository.php
├── Domain/Shared/
│   ├── Exceptions/ExcecaoDeDominio.php
│   └── ValueObjects/
│       ├── Dinheiro.php
│       └── Quantidade.php
├── Application/Shared/Contracts/
│   ├── GeradorIdentificador.php
│   ├── Relogio.php
│   └── UnidadeDeTrabalho.php
├── Application/Vendas/
│   ├── DTOs/RegistrarVendaDto.php
│   └── UseCases/RegistrarVenda.php
├── Infrastructure/
│   ├── Persistence/Eloquent/Models/VendaModel.php
│   ├── Persistence/Repositories/EloquentVendaRepository.php
│   ├── Persistence/LaravelUnidadeDeTrabalho.php
│   ├── Identifiers/LaravelGeradorIdentificador.php
│   └── Time/RelogioSistema.php
└── Presentation/Http/Vendas/
    ├── Contracts/VendaPayload.php
    ├── Controllers/RegistrarVendaController.php
    ├── Requests/RegistrarVendaRequest.php
    └── Resources/VendaResource.php
```

## Domain: enum

```php
<?php

declare(strict_types=1);

namespace App\Domain\Vendas\Enums;

enum StatusVenda: string
{
    case ABERTA = 'ABERTA';
    case AGUARDANDO_PAGAMENTO = 'AGUARDANDO_PAGAMENTO';
    case PAGA = 'PAGA';
    case CANCELADA = 'CANCELADA';
}
```

## Domain: código de erro

```php
<?php

declare(strict_types=1);

namespace App\Domain\Vendas\Enums;

enum CodigoErroVenda: string
{
    case VENDA_SEM_ITENS = 'VENDA_SEM_ITENS';
    case QUANTIDADE_INVALIDA = 'QUANTIDADE_INVALIDA';
    case VALOR_MONETARIO_INVALIDO = 'VALOR_MONETARIO_INVALIDO';
    case VENDA_NAO_ENCONTRADA = 'VENDA_NAO_ENCONTRADA';
    case ESTOQUE_INSUFICIENTE = 'ESTOQUE_INSUFICIENTE';
}
```

## Domain: exceção

```php
<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exceptions;

use BackedEnum;
use DomainException;

abstract class ExcecaoDeDominio extends DomainException
{
    abstract public function codigo(): BackedEnum;
}
```

```php
<?php

declare(strict_types=1);

namespace App\Domain\Vendas\Exceptions;

use App\Domain\Shared\Exceptions\ExcecaoDeDominio;
use App\Domain\Vendas\Enums\CodigoErroVenda;

final class VendaSemItensException extends ExcecaoDeDominio
{
    public function __construct()
    {
        parent::__construct(CodigoErroVenda::VENDA_SEM_ITENS->value);
    }

    public function codigo(): CodigoErroVenda
    {
        return CodigoErroVenda::VENDA_SEM_ITENS;
    }
}
```

A exceção transporta um código estável. Não use seu texto interno como mensagem de interface.

## Domain: Value Objects

```php
<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObjects;

use App\Domain\Vendas\Enums\CodigoErroVenda;
use InvalidArgumentException;

final readonly class Quantidade
{
    public const int MINIMA = 1;

    private function __construct(private int $valor)
    {
        if ($valor < self::MINIMA) {
            throw new InvalidArgumentException(
                CodigoErroVenda::QUANTIDADE_INVALIDA->value,
            );
        }
    }

    public static function criar(int $valor): self
    {
        return new self($valor);
    }

    public function valor(): int
    {
        return $this->valor;
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObjects;

use App\Domain\Vendas\Enums\CodigoErroVenda;
use InvalidArgumentException;

final readonly class Dinheiro
{
    public const int ZERO_CENTAVOS = 0;

    private function __construct(private int $centavos)
    {
        if ($centavos < self::ZERO_CENTAVOS) {
            throw new InvalidArgumentException(
                CodigoErroVenda::VALOR_MONETARIO_INVALIDO->value,
            );
        }
    }

    public static function deCentavos(int $centavos): self
    {
        return new self($centavos);
    }

    public static function zero(): self
    {
        return new self(self::ZERO_CENTAVOS);
    }

    public function somar(self $outro): self
    {
        return new self($this->centavos + $outro->centavos);
    }

    public function multiplicar(Quantidade $quantidade): self
    {
        return new self($this->centavos * $quantidade->valor());
    }

    public function centavos(): int
    {
        return $this->centavos;
    }
}
```

Valores monetários não usam `float`.

## Domain: entidades

```php
<?php

declare(strict_types=1);

namespace App\Domain\Vendas\Entities;

use App\Domain\Shared\ValueObjects\Dinheiro;
use App\Domain\Shared\ValueObjects\Quantidade;
use App\Domain\Vendas\ValueObjects\ProdutoId;

final readonly class ItemVenda
{
    public function __construct(
        private ProdutoId $produtoId,
        private Quantidade $quantidade,
        private Dinheiro $valorUnitario,
    ) {
    }

    public function produtoId(): ProdutoId
    {
        return $this->produtoId;
    }

    public function quantidade(): Quantidade
    {
        return $this->quantidade;
    }

    public function valorUnitario(): Dinheiro
    {
        return $this->valorUnitario;
    }

    public function subtotal(): Dinheiro
    {
        return $this->valorUnitario->multiplicar($this->quantidade);
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Domain\Vendas\Entities;

use App\Domain\Shared\ValueObjects\Dinheiro;
use App\Domain\Vendas\Enums\StatusVenda;
use App\Domain\Vendas\Exceptions\VendaSemItensException;
use App\Domain\Vendas\ValueObjects\VendaId;
use DateTimeImmutable;

final class Venda
{
    /**
     * @param list<ItemVenda> $itens
     */
    private function __construct(
        private readonly VendaId $id,
        private readonly ?string $clienteId,
        private array $itens,
        private StatusVenda $status,
        private readonly DateTimeImmutable $registradaEm,
    ) {
        if ($itens === []) {
            throw new VendaSemItensException();
        }
    }

    /**
     * @param list<ItemVenda> $itens
     */
    public static function registrar(
        VendaId $id,
        ?string $clienteId,
        array $itens,
        DateTimeImmutable $registradaEm,
    ): self {
        return new self(
            id: $id,
            clienteId: $clienteId,
            itens: $itens,
            status: StatusVenda::ABERTA,
            registradaEm: $registradaEm,
        );
    }

    public function id(): VendaId
    {
        return $this->id;
    }

    public function clienteId(): ?string
    {
        return $this->clienteId;
    }

    /** @return list<ItemVenda> */
    public function itens(): array
    {
        return $this->itens;
    }

    public function status(): StatusVenda
    {
        return $this->status;
    }

    public function registradaEm(): DateTimeImmutable
    {
        return $this->registradaEm;
    }

    public function total(): Dinheiro
    {
        $total = Dinheiro::zero();

        foreach ($this->itens as $item) {
            $total = $total->somar($item->subtotal());
        }

        return $total;
    }
}
```

## Domain: repositório

```php
<?php

declare(strict_types=1);

namespace App\Domain\Vendas\Repositories;

use App\Domain\Vendas\Entities\Venda;
use App\Domain\Vendas\ValueObjects\VendaId;

interface VendaRepository
{
    public function salvar(Venda $venda): void;

    public function obterPorId(VendaId $id): ?Venda;
}
```

## Application: contratos

```php
<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface GeradorIdentificador
{
    public function gerar(): string;
}
```

```php
<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

use DateTimeImmutable;

interface Relogio
{
    public function agora(): DateTimeImmutable;
}
```

```php
<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface UnidadeDeTrabalho
{
    /** @template T
     *  @param callable(): T $operacao
     *  @return T
     */
    public function executar(callable $operacao): mixed;
}
```

## Application: DTO e caso de uso

```php
<?php

declare(strict_types=1);

namespace App\Application\Vendas\DTOs;

final readonly class RegistrarVendaDto
{
    /**
     * @param list<array{
     *   produtoId: string,
     *   quantidade: int,
     *   valorUnitarioCentavos: int
     * }> $itens
     */
    public function __construct(
        public ?string $clienteId,
        public array $itens,
    ) {
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Application\Vendas\UseCases;

use App\Application\Shared\Contracts\GeradorIdentificador;
use App\Application\Shared\Contracts\Relogio;
use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use App\Application\Vendas\DTOs\RegistrarVendaDto;
use App\Domain\Shared\ValueObjects\Dinheiro;
use App\Domain\Shared\ValueObjects\Quantidade;
use App\Domain\Vendas\Entities\ItemVenda;
use App\Domain\Vendas\Entities\Venda;
use App\Domain\Vendas\Repositories\VendaRepository;
use App\Domain\Vendas\ValueObjects\ProdutoId;
use App\Domain\Vendas\ValueObjects\VendaId;

final readonly class RegistrarVenda
{
    public function __construct(
        private VendaRepository $vendas,
        private UnidadeDeTrabalho $unidadeDeTrabalho,
        private GeradorIdentificador $geradorIdentificador,
        private Relogio $relogio,
    ) {
    }

    public function executar(RegistrarVendaDto $dto): Venda
    {
        return $this->unidadeDeTrabalho->executar(
            function () use ($dto): Venda {
                $itens = array_map(
                    static fn (array $item): ItemVenda => new ItemVenda(
                        produtoId: ProdutoId::fromString($item['produtoId']),
                        quantidade: Quantidade::criar($item['quantidade']),
                        valorUnitario: Dinheiro::deCentavos(
                            $item['valorUnitarioCentavos'],
                        ),
                    ),
                    $dto->itens,
                );

                $venda = Venda::registrar(
                    id: VendaId::fromString(
                        $this->geradorIdentificador->gerar(),
                    ),
                    clienteId: $dto->clienteId,
                    itens: $itens,
                    registradaEm: $this->relogio->agora(),
                );

                $this->vendas->salvar($venda);

                return $venda;
            },
        );
    }
}
```

O caso de uso coordena. A entidade decide.

## Infrastructure: implementações

```php
<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Application\Shared\Contracts\UnidadeDeTrabalho;
use Illuminate\Support\Facades\DB;

final class LaravelUnidadeDeTrabalho implements UnidadeDeTrabalho
{
    public function executar(callable $operacao): mixed
    {
        return DB::transaction($operacao);
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Infrastructure\Identifiers;

use App\Application\Shared\Contracts\GeradorIdentificador;
use Illuminate\Support\Str;

final class LaravelGeradorIdentificador implements GeradorIdentificador
{
    public function gerar(): string
    {
        return (string) Str::uuid();
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Infrastructure\Time;

use App\Application\Shared\Contracts\Relogio;
use DateTimeImmutable;

final class RelogioSistema implements Relogio
{
    public function agora(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
```

Models Eloquent e repositórios concretos ficam em `src/Infrastructure`. Eles convertem entidades para persistência e vice-versa, sem conter regras de negócio.

## Presentation: contrato, request e controller

```php
<?php

declare(strict_types=1);

namespace App\Presentation\Http\Vendas\Contracts;

final class VendaPayload
{
    public const string CLIENTE_ID = 'cliente_id';
    public const string ITENS = 'itens';
    public const string PRODUTO_ID = 'produto_id';
    public const string QUANTIDADE = 'quantidade';
    public const string VALOR_UNITARIO_CENTAVOS =
        'valor_unitario_centavos';

    private function __construct()
    {
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Presentation\Http\Vendas\Requests;

use App\Domain\Shared\ValueObjects\Dinheiro;
use App\Domain\Shared\ValueObjects\Quantidade;
use App\Presentation\Http\Vendas\Contracts\VendaPayload;
use Illuminate\Foundation\Http\FormRequest;

final class RegistrarVendaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $itens = VendaPayload::ITENS;

        return [
            VendaPayload::CLIENTE_ID => ['nullable', 'uuid'],
            $itens => [
                'required',
                'array',
                'min:' . Quantidade::MINIMA,
            ],
            $itens . '.*.' . VendaPayload::PRODUTO_ID => [
                'required',
                'uuid',
            ],
            $itens . '.*.' . VendaPayload::QUANTIDADE => [
                'required',
                'integer',
                'min:' . Quantidade::MINIMA,
            ],
            $itens . '.*.' . VendaPayload::VALOR_UNITARIO_CENTAVOS => [
                'required',
                'integer',
                'min:' . Dinheiro::ZERO_CENTAVOS,
            ],
        ];
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Presentation\Http\Vendas\Controllers;

use App\Application\Vendas\DTOs\RegistrarVendaDto;
use App\Application\Vendas\UseCases\RegistrarVenda;
use App\Presentation\Http\Vendas\Contracts\VendaPayload;
use App\Presentation\Http\Vendas\Requests\RegistrarVendaRequest;
use App\Presentation\Http\Vendas\Resources\VendaResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class RegistrarVendaController
{
    public function __construct(
        private RegistrarVenda $registrarVenda,
    ) {
    }

    public function __invoke(RegistrarVendaRequest $request): JsonResponse
    {
        $dados = $request->validated();

        $itens = array_map(
            static fn (array $item): array => [
                'produtoId' => $item[VendaPayload::PRODUTO_ID],
                'quantidade' => $item[VendaPayload::QUANTIDADE],
                'valorUnitarioCentavos' =>
                    $item[VendaPayload::VALOR_UNITARIO_CENTAVOS],
            ],
            $dados[VendaPayload::ITENS],
        );

        $venda = $this->registrarVenda->executar(
            new RegistrarVendaDto(
                clienteId: $dados[VendaPayload::CLIENTE_ID] ?? null,
                itens: $itens,
            ),
        );

        return VendaResource::make($venda)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
```

O controller recebe, adapta, delega e responde.

# Mensagens e internacionalização

Mensagens para o usuário ficam nos arquivos de tradução do Laravel, nunca no domínio.

```text
lang/
├── pt_BR/
│   ├── vendas.php
│   ├── entregas.php
│   ├── estoque.php
│   ├── producao.php
│   └── errors.php
└── en/
    └── ...
```

Exemplo `lang/pt_BR/vendas.php`:

```php
<?php

declare(strict_types=1);

return [
    'errors' => [
        'VENDA_SEM_ITENS' =>
            'Uma venda deve possuir pelo menos um item.',
        'QUANTIDADE_INVALIDA' =>
            'A quantidade informada é inválida.',
        'VALOR_MONETARIO_INVALIDO' =>
            'O valor monetário informado é inválido.',
        'VENDA_NAO_ENCONTRADA' =>
            'A venda informada não foi encontrada.',
        'ESTOQUE_INSUFICIENTE' =>
            'Não há estoque suficiente para concluir a venda.',
    ],
];
```

A apresentação converte código em mensagem:

```php
$codigo = $exception->codigo()->value;

return response()->json(
    data: [
        'error' => [
            'code' => $codigo,
            'message' => __('vendas.errors.' . $codigo),
        ],
    ],
    status: Response::HTTP_UNPROCESSABLE_ENTITY,
);
```

Regra:

```text
Código de erro pertence ao contrato.
Mensagem pertence à apresentação.
```

Clientes nunca tomam decisões comparando textos.

Incorreto:

```typescript
if (error.message === 'Não há estoque suficiente...') {
}
```

Correto:

```typescript
if (error.code === CodigoErroVenda.ESTOQUE_INSUFICIENTE) {
}
```

# Valores mágicos

Evite strings, números e códigos mágicos quando possuírem significado técnico ou de negócio.

Representar explicitamente:

- status;
- tipos;
- categorias;
- códigos de erro;
- permissões;
- nomes de eventos;
- nomes de filas;
- chaves de cache;
- headers HTTP;
- claims;
- endpoints;
- timeouts;
- limites;
- percentuais;
- códigos HTTP;
- chaves de armazenamento;
- valores monetários.

Nem todo literal exige constante.

Permitido:

```php
return $contador + 1;
```

Permitido:

```php
if ($itens === []) {
}
```

## Árvore de decisão

```text
É mensagem para o usuário?
    └── Arquivo de tradução

Possui comportamento, validação ou invariantes?
    └── Value Object

Representa conjunto fechado, estado ou tipo?
    └── Enum

Varia por ambiente?
    └── Configuração

É fixo, compartilhado e sem comportamento?
    └── Constante

É local, evidente e sem significado próprio?
    └── Literal permitido
```

## HTTP

Não use números HTTP diretamente.

```php
Response::HTTP_OK;
Response::HTTP_CREATED;
Response::HTTP_NO_CONTENT;
Response::HTTP_BAD_REQUEST;
Response::HTTP_UNAUTHORIZED;
Response::HTTP_FORBIDDEN;
Response::HTTP_NOT_FOUND;
Response::HTTP_CONFLICT;
Response::HTTP_UNPROCESSABLE_ENTITY;
```

## Configurações

Valores operacionais variáveis ficam em `config/`.

```php
return [
    'url' => env('HIDRA_URL'),
    'timeout_seconds' => env('HIDRA_TIMEOUT_SECONDS', 10),
    'retry_attempts' => env('HIDRA_RETRY_ATTEMPTS', 3),
];
```

Não use `env()` fora dos arquivos de configuração.

## Endpoints

Centralize endpoints consumidos.

```php
final class HidraEndpoint
{
    public const string VENDAS = '/api/v1/vendas';

    private const string CONFIRMAR_ENTREGA =
        '/api/v1/entregas/%s/confirmacao';

    public static function confirmarEntrega(string $entregaId): string
    {
        return sprintf(self::CONFIRMAR_ENTREGA, $entregaId);
    }
}
```

```typescript
const API_PREFIX = '/api/v1';

export const HidraEndpoint = {
  VENDAS: `${API_PREFIX}/vendas`,
  confirmarEntrega: (entregaId: string): string =>
    `${API_PREFIX}/entregas/${entregaId}/confirmacao`,
} as const;
```

# Projetos clientes

## Argos

Laravel + Blade para backoffice administrativo.

Pode:

- apresentar telas;
- coletar dados;
- validar formato de interface;
- consumir o Hidra;
- controlar sessão e navegação;
- adaptar respostas para Blade.

Não pode:

- implementar regra de negócio;
- acessar o banco do Hidra;
- recalcular valores oficiais;
- reproduzir validações de domínio;
- alterar estado sem chamar o Hidra.

## Farm

React Native para operações da granja.

Pode:

- apresentar interfaces operacionais;
- coletar dados;
- consumir o Hidra;
- manter estado de tela;
- manter cache temporário;
- trabalhar offline de forma limitada;
- sincronizar comandos.

Não pode:

- decidir regras de produção;
- calcular estoque oficial;
- considerar uma operação local definitivamente válida;
- duplicar regras do Hidra.

## Hermes

React Native para entregadores.

Pode:

- listar entregas;
- iniciar rota;
- registrar tentativa;
- confirmar entrega;
- anexar evidências;
- coletar assinatura;
- sincronizar dados offline.

Não pode:

- decidir transições válidas;
- confirmar entrega apenas localmente;
- recalcular valores;
- alterar diretamente o estado oficial.

## Pluto

Laravel Web para ponto de venda.

Pode:

- apresentar o PDV;
- coletar itens;
- consultar preços;
- identificar clientes;
- encaminhar pagamentos;
- imprimir comprovantes.

Não pode:

- definir preço oficial;
- aplicar desconto sem autorização;
- baixar estoque diretamente;
- confirmar pagamento sozinho;
- concluir venda apenas localmente.

O total oficial é sempre o retornado pelo Hidra.

# Fonte oficial e operação offline

O Hidra é a fonte oficial de:

- vendas;
- pedidos;
- entregas;
- clientes;
- fornecedores;
- estoque;
- produção;
- funcionários;
- tarefas;
- produtos;
- preços;
- pagamentos;
- estados;
- transições;
- autorizações.

Farm e Hermes podem operar offline de forma limitada:

- dados locais são temporários;
- comandos possuem identificador idempotente;
- operações pendentes ficam em fila local;
- o Hidra revalida tudo;
- conflitos são resolvidos pelo Hidra;
- o estado definitivo vem da API.

# Permissões

Permissões usam enum ou objeto constante tipado.

```php
enum Permissao: string
{
    case VENDA_CRIAR = 'venda.criar';
    case VENDA_CANCELAR = 'venda.cancelar';
    case ENTREGA_CONFIRMAR = 'entrega.confirmar';
    case ESTOQUE_MOVIMENTAR = 'estoque.movimentar';
}
```

Ocultar um botão não substitui a autorização no Hidra.

# Cache, filas e eventos

Centralize chaves técnicas quando houver significado ou reutilização.

```php
final class CacheKey
{
    private const string PRODUTO_PREFIXO = 'produto';

    public static function produto(string $produtoId): string
    {
        return sprintf('%s:%s', self::PRODUTO_PREFIXO, $produtoId);
    }
}
```

TTL variável pertence à configuração.

```php
final class NomeFila
{
    public const string PADRAO = 'default';
    public const string PAGAMENTOS = 'pagamentos';
    public const string ENTREGAS = 'entregas';
}
```

Eventos internos preferem classes:

```php
final readonly class VendaRegistrada
{
    public function __construct(public string $vendaId)
    {
    }
}
```

# Contratos da API

As APIs devem:

- ser versionadas;
- possuir contratos explícitos;
- usar códigos HTTP adequados;
- retornar erros estruturados;
- não expor models Eloquent;
- manter nomenclatura consistente;
- preservar compatibilidade sempre que possível;
- indicar ações permitidas quando necessário.

```json
{
  "data": {
    "id": "40bbbf72-865e-46b3-8f43-a6bd842d57eb",
    "status": "ABERTA",
    "total_centavos": 6300,
    "acoes_permitidas": [
      "confirmar",
      "cancelar"
    ]
  }
}
```

A interface pode usar `acoes_permitidas`, mas a API valida novamente toda ação.

# Testes

## Hidra

Criar:

- testes unitários de domínio;
- testes de casos de uso;
- testes de repositórios;
- testes de endpoints;
- testes de autorização;
- testes de contratos;
- testes de tratamento de exceções.

Regras devem ser testadas sem HTTP, Eloquent ou banco sempre que possível.

## Clientes

Criar:

- testes de componentes;
- testes de apresentação;
- testes dos clientes HTTP;
- testes de tratamento de erros;
- testes de navegação;
- testes de sincronização;
- testes de estados offline.

Não duplicar nos clientes os testes das regras internas do Hidra.

# Comportamento obrigatório do agente

Quando uma solicitação tentar colocar regra de negócio em Argos, Farm, Hermes ou Pluto, responda:

> Esta funcionalidade contém regra de negócio e deve ser implementada no Hidra. No projeto cliente será implementado apenas o consumo da API e o tratamento da resposta.

Não implemente silenciosamente:

- regra de negócio em cliente;
- acesso direto ao banco do Hidra;
- dependência direta entre clientes;
- lógica comercial em controller;
- regra de domínio em model Eloquent;
- comparação por texto de erro;
- status como string literal;
- valores operacionais fixados no código;
- mensagens de usuário dentro do domínio;
- código da aplicação dentro de `app/`.

# Checklist final

Antes de concluir:

## Arquitetura

- O código próprio está em `src/`?
- O namespace está mapeado para `src/` no Composer?
- A regra está no Hidra?
- A regra está no domínio?
- O caso de uso apenas coordena?
- O controller apenas adapta?
- O domínio está desacoplado de Laravel e Eloquent?
- Dependências externas possuem contratos?
- A transação está na fronteira correta?

## Contratos e mensagens

- O código de erro é estável?
- A mensagem está em `lang/`?
- Clientes tratam erros pelo código?
- A API não expõe models Eloquent?
- O código HTTP usa constantes do framework?

## Valores mágicos

- Status usam enum?
- Conceitos validados usam Value Objects?
- Valores variáveis usam configuração?
- Endpoints estão centralizados?
- Permissões estão tipadas?
- Timeouts e retries estão em configuração?
- Valores monetários usam centavos inteiros?
- Datas e UUIDs são obtidos por contratos em Application?
- Não foram criadas constantes artificiais para literais evidentes?

## Clientes

- Consomem o Hidra?
- Não acessam o banco central?
- Não duplicam regras?
- Estado definitivo vem da API?
- Operações offline são idempotentes?

# Princípios finais

```text
Clientes apresentam e coletam dados.
Hidra decide e executa o negócio.
```

```text
Presentation recebe e responde.
Application coordena.
Domain decide.
Infrastructure implementa detalhes técnicos.
```

```text
Códigos de erro pertencem ao contrato.
Mensagens pertencem à apresentação.
```

```text
O código da aplicação fica em src/.
A pasta app/ não é usada para o código próprio do sistema.
```

```text
Não esconder conceitos em strings ou números soltos.
Representar explicitamente o significado do sistema.
```
