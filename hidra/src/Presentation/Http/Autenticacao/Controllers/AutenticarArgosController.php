<?php

declare(strict_types=1);

namespace App\Presentation\Http\Autenticacao\Controllers;

use App\Infrastructure\Persistence\SchemaContexto;
use App\Models\User;
use App\Presentation\Http\Autenticacao\Requests\AutenticarArgosRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

final class AutenticarArgosController
{
        public function __invoke(AutenticarArgosRequest $request): JsonResponse
    {
        $dados = $request->validated();
        $usuario = User::query()->where('username', $dados['username'])->first();

        if ($usuario === null || ! Hash::check($dados['password'], $usuario->password)) {
            return response()->json([
                'error' => ['code' => 'CREDENCIAIS_INVALIDAS'],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $permissoes = $this->permissoesArgos($usuario);

        if (! $usuario->eh_administrador && $permissoes === []) {
            return response()->json([
                'error' => ['code' => 'ACESSO_ARGOS_NEGADO'],
            ], Response::HTTP_FORBIDDEN);
        }

        $token = $usuario->createToken('argos', $permissoes)->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token,
                'nome' => $usuario->name,
                'eh_administrador' => $usuario->eh_administrador,
                'permissoes' => $permissoes,
            ],
        ]);
    }

    /** @return list<string> */
    private function permissoesArgos(User $usuario): array
    {
        if ($usuario->eh_administrador) {
            return ['*'];
        }

        $colaboradorPerfis = SchemaContexto::tabela('pessoas', 'colaborador_perfis');
        $perfilPermissoes = SchemaContexto::tabela('pessoas', 'perfil_permissoes');

        return DB::table('colaboradores as colaborador')
            ->join("{$colaboradorPerfis} as vinculo", 'vinculo.colaborador_id', '=', 'colaborador.id')
            ->join("{$perfilPermissoes} as permissao", 'permissao.perfil_id', '=', 'vinculo.perfil_id')
            ->where('colaborador.user_id', $usuario->id)
            ->where('permissao.permissao', 'like', 'argos.%')
            ->pluck('permissao.permissao')
            ->unique()
            ->values()
            ->all();
    }
}
