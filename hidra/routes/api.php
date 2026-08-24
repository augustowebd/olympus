<?php

use App\Presentation\Http\Pessoas\Controllers\GerenciarEnderecoController;
use App\Presentation\Http\Autenticacao\Controllers\AutenticarArgosController;
use App\Presentation\Http\Producao\Controllers\AlterarNucleoController;
use App\Presentation\Http\Producao\Controllers\CriarNucleoController;
use App\Presentation\Http\Producao\Controllers\ListarNucleosController;
use App\Presentation\Http\Producao\Controllers\RegistrarGalpaoController;
use App\Presentation\Http\Producao\Controllers\RemoverNucleoController;
use App\Presentation\Http\Producao\Controllers\VisualizarNucleoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('v1/autenticacoes/argos', AutenticarArgosController::class)
    ->middleware('throttle:6,1');

Route::prefix('v1')->middleware('auth:sanctum')->group(function (): void {
    Route::get('{tipo}/{proprietarioUuid}/enderecos', [GerenciarEnderecoController::class, 'listar'])->whereIn('tipo', ['colaborador', 'fornecedor', 'cliente']);
    Route::post('{tipo}/{proprietarioUuid}/enderecos', [GerenciarEnderecoController::class, 'criar'])->whereIn('tipo', ['colaborador', 'fornecedor', 'cliente']);
    Route::get('enderecos/{endUuid}', [GerenciarEnderecoController::class, 'visualizar']);
    Route::put('enderecos/{endUuid}', [GerenciarEnderecoController::class, 'alterar']);
    Route::delete('enderecos/{endUuid}', [GerenciarEnderecoController::class, 'remover']);
    Route::post('galpoes', RegistrarGalpaoController::class);

    Route::post('nucleos', CriarNucleoController::class);
    Route::get('nucleos', ListarNucleosController::class);
    Route::get('nucleos/{nclUuid}', VisualizarNucleoController::class);
    Route::put('nucleos/{nclUuid}', AlterarNucleoController::class);
    Route::delete('nucleos/{nclUuid}', RemoverNucleoController::class);
});
