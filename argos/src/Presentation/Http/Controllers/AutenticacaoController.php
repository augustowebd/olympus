<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

final class AutenticacaoController
{
    public function criar(): View|RedirectResponse
    {
        if (session()->has('hidra_token')) {
            return redirect()->route('inicio');
        }

        return view('autenticacao.login');
    }

    public function armazenar(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'username' => [
                'required',
                'string',
                'min:4',
                'max:255',
                Rule::when($request->input('username') !== 'admin', ['email']),
            ],
            'password' => [
                'required',
                'string',
                'min:4',
                'max:32',
                'regex:/\\p{L}/u',
                'regex:/\\d/',
            ],
        ], [
            'username.min' => 'O usuário deve ter ao menos :min caracteres.',
            'username.max' => 'O usuário deve ter no máximo :max caracteres.',
            'username.email' => 'Informe o usuário admin ou um e-mail válido.',
            'password.min' => 'A senha deve ter ao menos :min caracteres.',
            'password.max' => 'A senha deve ter no máximo :max caracteres.',
            'password.regex' => 'A senha deve conter ao menos uma letra e um número.',
        ]);

        $resposta = Http::acceptJson()
            ->post(config('services.hidra.url').'/api/v1/autenticacoes/argos', $dados);

        if (! $resposta->successful()) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Usuário, senha ou acesso inválido.']);
        }

        $autenticacao = $resposta->json('data');

        $request->session()->regenerate();
        $request->session()->put([
            'hidra_token' => $autenticacao['token'],
            'nome_usuario' => $autenticacao['nome'],
            'permissoes' => $autenticacao['permissoes'],
        ]);

        return redirect()->intended(route('inicio'));
    }

    public function remover(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
