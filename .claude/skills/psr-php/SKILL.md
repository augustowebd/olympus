---
name: psr-php
description: Aplicar PSR-1, PSR-4 e PSR-12 a código PHP. Use ao criar, alterar, revisar ou formatar arquivos PHP, especialmente quando houver linhas longas, classes ou métodos comprimidos, imports desordenados, ou dúvida sobre boas práticas de estilo.
---

# PSR para PHP

## Regra do projeto

- Usar `declare(strict_types=1);`, namespace PSR-4 e imports explícitos.
- Manter indentação de quatro espaços, uma instrução por linha e chaves PSR-12.
- Tratar 120 caracteres como limite máximo do projeto. Quebrar linhas acima dele
  manualmente; preferir até 80 quando isso melhorar a leitura.
- Nunca comprimir classe, construtor, método, array, `match`, consulta ou chamada
  longa em uma linha.

## Fluxo obrigatório

1. Ler o arquivo completo e preservar o comportamento.
2. Usar `vendor/bin/pint` nos arquivos alterados para regras mecânicas.
3. Medir o comprimento de todas as linhas PHP alteradas:

   ```bash
   awk 'length($0) > 120 { print FILENAME ":" FNR ":" length($0) }' arquivo.php
   ```

4. Corrigir manualmente cada resultado. O formatter não substitui essa etapa.
5. Rodar `php -l` nos arquivos alterados, `git diff --check` e a menor suíte de
   testes relevante.

## Quebras de linha

Quebrar parâmetros, argumentos e arrays com um item por linha:

```php
public function executar(
    EnderecoDto $dto,
    TipoProprietarioEndereco $tipo,
    string $proprietarioUuid,
): Endereco {
    return $this->servico->criar(
        $dto,
        $tipo,
        $proprietarioUuid,
    );
}
```

Usar etapas encadeadas em linhas separadas quando a expressão não couber:

```php
return DB::table($tabela)
    ->where('end_uuid', $uuid)
    ->first();
```

## Boas práticas além da formatação

- Declarar tipos de parâmetros, retornos e propriedades quando o PHP suportar.
- Usar `final` em classes sem extensão prevista e `readonly` em objetos imutáveis.
- Preferir nomes claros a abreviações e evitar comentários que apenas repitam código.
- Manter regra de negócio fora de controllers, requests e modelos Eloquent.
- Não alterar comportamento durante uma tarefa exclusivamente de formatação.
