<?php

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

Route::prefix('v1')->middleware('auth:sanctum')->group(function (): void {
    Route::post('galpoes', RegistrarGalpaoController::class);

    Route::post('nucleos', CriarNucleoController::class);
    Route::get('nucleos', ListarNucleosController::class);
    Route::get('nucleos/{nclUuid}', VisualizarNucleoController::class);
    Route::put('nucleos/{nclUuid}', AlterarNucleoController::class);
    Route::delete('nucleos/{nclUuid}', RemoverNucleoController::class);
});
