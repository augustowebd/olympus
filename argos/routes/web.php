<?php

use App\Presentation\Http\Controllers\AutenticacaoController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AutenticacaoController::class, 'criar'])->name('login');
Route::post('/login', [AutenticacaoController::class, 'armazenar'])->name('login.armazenar');
Route::post('/sair', [AutenticacaoController::class, 'remover'])->name('sair');

Route::middleware('hidra.autenticado')->group(function (): void {
    Route::get('/', function () {
        return view('inicio');
    })->name('inicio');

    Route::view('/colaboradores', 'granja.colaboradores')
        ->name('colaboradores.index');
});
