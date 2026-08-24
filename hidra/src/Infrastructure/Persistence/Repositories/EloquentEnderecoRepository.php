<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Pessoas\Entities\Endereco;
use App\Domain\Pessoas\Enums\TipoProprietarioEndereco;
use App\Domain\Pessoas\Repositories\EnderecoRepository;
use App\Domain\Pessoas\ValueObjects\Cep;
use App\Domain\Pessoas\ValueObjects\EnderecoId;
use App\Domain\Pessoas\ValueObjects\TextoEndereco;
use App\Infrastructure\Persistence\SchemaContexto;
use Illuminate\Support\Facades\DB;

final class EloquentEnderecoRepository implements EnderecoRepository
{
    private function tabela(string $nome): string
    {
        return SchemaContexto::tabela('pessoas', $nome);
    }

    public function salvar(Endereco $endereco): void
    {
        $cidade = DB::table($this->tabela('cidades'))
            ->where('cid_uuid', $endereco->cidadeUuid())
            ->value('id');

        DB::table($this->tabela('enderecos'))->updateOrInsert(
            ['end_uuid' => $endereco->id()->valor()],
            [
                'cep' => $endereco->cep(),
                'logradouro' => $endereco->logradouro(),
                'numero' => $endereco->numero(),
                'complemento' => $endereco->complemento(),
                'bairro' => $endereco->bairro(),
                'cidade_id' => $cidade,
            ],
        );
    }

    public function obter(EnderecoId $id): ?Endereco
    {
        $registro = DB::table($this->tabela('enderecos').' as e')
            ->join($this->tabela('cidades').' as c', 'c.id', '=', 'e.cidade_id')
            ->where('e.end_uuid', $id->valor())
            ->select('e.*', 'c.cid_uuid')
            ->first();

        if ($registro === null) {
            return null;
        }

        return Endereco::registrar(
            EnderecoId::fromString($registro->end_uuid),
            Cep::deTexto($registro->cep),
            TextoEndereco::deTexto($registro->logradouro),
            TextoEndereco::deTexto($registro->numero),
            $registro->complemento,
            TextoEndereco::deTexto($registro->bairro),
            $registro->cid_uuid,
        );
    }

    public function localidadeExiste(string $paisUuid, string $ufUuid, string $cidadeUuid): bool
    {
        return DB::table($this->tabela('cidades').' as c')
            ->join($this->tabela('ufs').' as u', 'u.id', '=', 'c.uf_id')
            ->join($this->tabela('paises').' as p', 'p.id', '=', 'u.pais_id')
            ->where('p.pas_uuid', $paisUuid)
            ->where('u.est_uuid', $ufUuid)
            ->where('c.cid_uuid', $cidadeUuid)
            ->exists();
    }

    public function vincular(TipoProprietarioEndereco $tipo, string $proprietarioUuid, EnderecoId $enderecoId): void
    {
        $endereco = DB::table($this->tabela('enderecos'))
            ->where('end_uuid', $enderecoId->valor())
            ->value('id');
        [$tabela, $coluna] = $this->ligacao($tipo);
        DB::table($tabela)->insertOrIgnore([
            $coluna => $proprietarioUuid,
            'endereco_id' => $endereco,
        ]);
    }

    public function listar(TipoProprietarioEndereco $tipo, string $proprietarioUuid): array
    {
        [$view, $coluna] = $this->view($tipo);

        return DB::table($view)
            ->where($coluna, $proprietarioUuid)
            ->get()
            ->map(fn (object $registro): array => (array) $registro)
            ->all();
    }

    public function estaVinculado(EnderecoId $id): bool
    {
        $interno = DB::table($this->tabela('enderecos'))
            ->where('end_uuid', $id->valor())
            ->value('id');
        foreach (TipoProprietarioEndereco::cases() as $tipo) {
            [$tabela] = $this->ligacao($tipo);
            if (DB::table($tabela)->where('endereco_id', $interno)->exists()) {
                return true;
            }
        }

        return false;
    }

    public function remover(EnderecoId $id): void
    {
        DB::table($this->tabela('enderecos'))->where('end_uuid', $id->valor())->delete();
    }

    private function ligacao(TipoProprietarioEndereco $tipo): array
    {
        return match ($tipo) {
            TipoProprietarioEndereco::COLABORADOR => [
                $this->tabela('colaboradores_enderecos'),
                'colaborador_id',
            ],
            TipoProprietarioEndereco::FORNECEDOR => [
                $this->tabela('fornecedores_enderecos'),
                'fornecedor_id',
            ],
            TipoProprietarioEndereco::CLIENTE => [
                $this->tabela('clientes_enderecos'),
                'cliente_id',
            ],
        };
    }

    private function view(TipoProprietarioEndereco $tipo): array
    {
        return match ($tipo) {
            TipoProprietarioEndereco::COLABORADOR => [
                $this->tabela('vw_colaborador_endereco'),
                'colaborador_uuid',
            ],
            TipoProprietarioEndereco::FORNECEDOR => [
                $this->tabela('vw_fornecedor_endereco'),
                'fornecedor_uuid',
            ],
            TipoProprietarioEndereco::CLIENTE => [
                $this->tabela('vw_cliente_endereco'),
                'cliente_uuid',
            ],
        };
    }
}
