<?php

declare(strict_types=1);

use App\Infrastructure\Persistence\SchemaContexto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (SchemaContexto::suportaSchema()) {
            DB::statement('CREATE SCHEMA IF NOT EXISTS pessoas');
        }

        $paises = $this->tabela('paises');
        $ufs = $this->tabela('ufs');
        $cidades = $this->tabela('cidades');
        $enderecos = $this->tabela('enderecos');

        Schema::create($paises, function (Blueprint $table): void {
            $table->id();
            $table->uuid('pas_uuid')->unique();
            $table->string('nome');
            $table->string('sigla', 2)->unique();
            $table->timestamps();
        });

        Schema::create($ufs, function (Blueprint $table) use ($paises): void {
            $table->id();
            $table->uuid('est_uuid')->unique();
            $table->foreignId('pais_id')->constrained($paises)->restrictOnDelete();
            $table->string('nome');
            $table->string('sigla', 2);
            $table->unique(['pais_id', 'sigla']);
            $table->timestamps();
        });

        Schema::create($cidades, function (Blueprint $table) use ($ufs): void {
            $table->id();
            $table->uuid('cid_uuid')->unique();
            $table->foreignId('uf_id')->constrained($ufs)->restrictOnDelete();
            $table->string('nome');
            $table->unique(['uf_id', 'nome']);
            $table->timestamps();
        });

        Schema::create($enderecos, function (Blueprint $table) use ($cidades): void {
            $table->id();
            $table->uuid('end_uuid')->unique();
            $table->string('cep');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->foreignId('cidade_id')->constrained($cidades)->restrictOnDelete();
            $table->timestamps();
        });

        $this->criarLigacao('colaboradores_enderecos', 'colaborador_id', 'colaboradores', $enderecos);
        $this->criarLigacao('fornecedores_enderecos', 'fornecedor_id', 'fornecedores', $enderecos);
        $this->criarLigacao('clientes_enderecos', 'cliente_id', 'clientes', $enderecos);

        $this->criarViews();
    }

    public function down(): void
    {
        foreach ([
            'vw_cliente_endereco',
            'vw_fornecedor_endereco',
            'vw_colaborador_endereco',
        ] as $view) {
            DB::statement('DROP VIEW IF EXISTS '.$this->tabela($view));
        }

        foreach ([
            'clientes_enderecos',
            'fornecedores_enderecos',
            'colaboradores_enderecos',
            'enderecos',
            'cidades',
            'ufs',
            'paises',
        ] as $tabela) {
            Schema::dropIfExists($this->tabela($tabela));
        }
    }

    private function criarLigacao(
        string $tabela,
        string $proprietario,
        string $tabelaProprietario,
        string $enderecos,
    ): void
    {
        Schema::create($this->tabela($tabela), function (
            Blueprint $table,
        ) use ($proprietario, $tabelaProprietario, $enderecos): void {
            $table->uuid($proprietario);
            $table->foreign($proprietario)->references('id')->on($tabelaProprietario)->cascadeOnDelete();
            $table->foreignId('endereco_id')->constrained($enderecos)->restrictOnDelete();
            $table->unique([$proprietario, 'endereco_id']);
        });
    }

    private function criarViews(): void
    {
        $enderecos = $this->tabela('enderecos');
        $cidades = $this->tabela('cidades');
        $ufs = $this->tabela('ufs');
        $paises = $this->tabela('paises');

        foreach ([
            'colaborador' => 'colaboradores_enderecos',
            'fornecedor' => 'fornecedores_enderecos',
            'cliente' => 'clientes_enderecos',
        ] as $proprietario => $ligacao) {
            $view = $this->tabela("vw_{$proprietario}_endereco");
            $ligacao = $this->tabela($ligacao);
            $id = "{$proprietario}_id";

            DB::statement("CREATE VIEW {$view} AS
                SELECT ligacao.{$id} AS {$proprietario}_uuid,
                       endereco.end_uuid, endereco.cep, endereco.logradouro,
                       endereco.numero, endereco.complemento, endereco.bairro,
                       cidade.cid_uuid AS cidade_uuid, cidade.nome AS cidade_nome,
                       uf.est_uuid AS uf_uuid, uf.sigla AS uf_sigla,
                       pais.pas_uuid AS pais_uuid, pais.nome AS pais_nome
                FROM {$ligacao} ligacao
                INNER JOIN {$enderecos} endereco ON endereco.id = ligacao.endereco_id
                INNER JOIN {$cidades} cidade ON cidade.id = endereco.cidade_id
                INNER JOIN {$ufs} uf ON uf.id = cidade.uf_id
                INNER JOIN {$paises} pais ON pais.id = uf.pais_id");
        }
    }

    private function tabela(string $tabela): string
    {
        return SchemaContexto::tabela('pessoas', $tabela);
    }
};
