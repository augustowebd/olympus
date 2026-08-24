<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar no Argos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="login">
        <section class="login__form-area" aria-labelledby="titulo-login">
            <div class="login__card">
                <header class="login__brand">
                    <h1 id="titulo-login">Granja ERP</h1>
                    <p>Entre para acompanhar sua granja.</p>
                </header>

                <form class="login__form" method="post" action="{{ route('login.armazenar') }}">
                    @csrf

                    @error('username')
                        <p class="alerta-erro" role="alert">{{ $message }}</p>
                    @enderror

                    <label class="campo campo--obrigatorio @error('username') campo--invalido @enderror" for="username">
                        Usuário
                        <input
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            autocomplete="username"
                            placeholder="seu@email.com"
                            minlength="4"
                            maxlength="255"
                            pattern="admin|[^\s@]+@[^\s@]+\.[^\s@]+"
                            title="Informe admin ou um e-mail válido."
                            required
                            autofocus
                        >
                    </label>

                    @error('password')
                        <p class="alerta-erro" role="alert">{{ $message }}</p>
                    @enderror

                    <label class="campo campo--obrigatorio @error('password') campo--invalido @enderror" for="password">
                        Senha
                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            minlength="4"
                            maxlength="32"
                            pattern="(?=.*[A-Za-z])(?=.*[0-9]).{4,32}"
                            title="Use de 4 a 32 caracteres, com ao menos uma letra e um número."
                            required
                        >
                    </label>

                    <button class="botao-primario" type="submit">Entrar</button>
                </form>
            </div>
        </section>

        <aside class="login__ilustracao" aria-label="Ilustração de galpões da granja">
            <span>foto da granja / galpões</span>
        </aside>
    </main>
</body>
</html>
