<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel | Argos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a class="sidebar__marca" href="{{ route('inicio') }}">Granja ERP</a>

            <nav class="sidebar__navegacao" aria-label="Navegação principal">
                <a class="item-navegacao item-navegacao--ativo" href="{{ route('inicio') }}" aria-current="page">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7.5" height="7.5" rx="1.5"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="1.5"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="1.5"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.5"/></svg>
                    Painel
                </a>
                <span class="grupo-navegacao">Granja</span>
                <a class="item-navegacao" href="{{ route('colaboradores.index') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M3 20c0-3.6 2.7-6.5 6-6.5s6 2.9 6 6.5"/><path d="M16 10a3 3 0 1 0 0-6"/><path d="M18 14c2 1 3 3.2 3 6"/></svg>
                    Colaboradores
                </a>
            </nav>

            <div class="sidebar__rodape">
                <span class="usuario">{{ session('nome_usuario') }}</span>
                <form method="post" action="{{ route('sair') }}">
                    @csrf
                    <button class="botao-sair" type="submit">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 5H5v14h5"/><path d="M13 8l4 4-4 4"/><path d="M8 12h9"/></svg>
                        Sair
                    </button>
                </form>
            </div>
        </aside>

        <main class="painel">
            <header class="painel__cabecalho">
                <div>
                    <h1>Painel geral</h1>
                    <p>Visão geral da sua granja.</p>
                </div>
            </header>

            <section class="metricas" aria-label="Indicadores da granja">
                @foreach ([
                    ['Produção do dia', 'ovos'], ['Postura', '%'], ['Consumo de ração', 'kg'],
                    ['Mortalidade', '%'], ['Estoque crítico', 'itens'], ['Pedidos pendentes', 'pedidos'], ['Faturamento', 'R$'],
                ] as [$titulo, $unidade])
                    <article class="card-metrica">
                        <span>{{ $titulo }}</span>
                        <strong>—</strong>
                        <small>{{ $unidade }}</small>
                    </article>
                @endforeach
            </section>

            <section class="painel__grade">
                <article class="card card--grafico">
                    <h2>Produção por galpão</h2>
                    <p>Os dados da última semana aparecerão aqui quando a integração de produção estiver disponível.</p>
                    <div class="grafico-vazio" aria-hidden="true">
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </article>

                <article class="card">
                    <h2>Alertas</h2>
                    <p class="estado-vazio">Nenhum alerta para exibir.</p>
                </article>
            </section>
        </main>
    </div>
</body>
</html>
