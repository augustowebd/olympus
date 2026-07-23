<?php

use App\Presentation\Http\Producao\Controllers\RegistrarGalpaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware('auth:sanctum')->group(function (): void {
    Route::post('galpoes', RegistrarGalpaoController::class);
});
