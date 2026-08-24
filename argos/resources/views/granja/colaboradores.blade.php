<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Colaboradores | Argos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <a class="sidebar__marca" href="{{ route('inicio') }}">Granja ERP</a>
        <nav class="sidebar__navegacao" aria-label="Navegação principal">
            <a class="item-navegacao" href="{{ route('inicio') }}"><span class="icone-nav">▦</span>Painel</a>
            <span class="grupo-navegacao">Granja</span>
            <a class="item-navegacao item-navegacao--ativo" href="{{ route('colaboradores.index') }}" aria-current="page"><span class="icone-nav">♙</span>Colaboradores</a>
            <span class="item-navegacao item-navegacao--indisponivel"><span class="icone-nav">◫</span>Produção</span>
            <span class="item-navegacao item-navegacao--indisponivel"><span class="icone-nav">□</span>Estoque</span>
            <span class="grupo-navegacao">Gestão</span>
            <span class="item-navegacao item-navegacao--indisponivel"><span class="icone-nav">◷</span>Relatórios</span>
        </nav>
        <div class="sidebar__rodape"><span class="usuario">{{ session('nome_usuario') }}</span><form method="post" action="{{ route('sair') }}">@csrf<button class="botao-sair" type="submit">Sair</button></form></div>
    </aside>
    @php
        $novo = request()->query('modo') === 'novo';
        $permissoes = session('permissoes', []);
        $podeCriar = in_array('*', $permissoes, true)
            || in_array('argos.colaborador.criar', $permissoes, true);
    @endphp
    <main class="area-trabalho cadastro">
        <header class="barra-superior"><span>Granja / Colaboradores</span><span class="barra-superior__usuario">{{ session('nome_usuario') }}</span></header>
        @if ($novo && $podeCriar)
        <header class="cadastro__cabecalho" style="width: 100%; max-width: 1100px;"><div><h1>Novo colaborador</h1><p>Preencha os dados abaixo para registrar o colaborador.</p></div><div class="acoes-formulario" style="display: flex; flex-direction: row; flex-wrap: nowrap; align-items: center; gap: 8px;"><a class="botao-secundario" href="{{ route('colaboradores.index') }}" style="display: grid; place-items: center; box-sizing: border-box; width: 132px; height: 44px; min-height: 44px;">Cancelar</a><button class="botao-primario" type="submit" form="formulario-colaborador" style="box-sizing: border-box; width: 132px; height: 44px; min-height: 44px;">Salvar</button></div></header>
        <form id="formulario-colaborador" class="formulario-colaborador" onsubmit="return false">
            <section class="card secao-formulario"><h2>Identificação</h2><div class="campos-duplos">
                <label class="campo campo--obrigatorio">Matrícula<input name="matricula" required placeholder="Ex.: 2026001"></label>
                <label class="campo campo--obrigatorio">Nome completo<input name="nome_completo" required autocomplete="name" placeholder="Nome completo"></label>
                <label class="campo">Apelido<input name="apelido" placeholder="Como prefere ser chamado"></label>
                <x-campo-data nome="data_nascimento" rotulo="Data de nascimento" obrigatorio />
                <label class="campo campo--obrigatorio">Gênero<select name="genero" required><option value="" selected disabled>Selecione</option><option>Feminino</option><option>Masculino</option><option>Outro</option><option>Prefiro não informar</option></select></label>
                <label class="campo campo--obrigatorio">Escolaridade<select name="escolaridade" required><option value="" selected disabled>Selecione</option><option>Ensino fundamental</option><option>Ensino médio</option><option>Ensino superior</option></select></label>
            </div></section>
            <section class="card secao-formulario"><h2>Endereço</h2><div class="campos-duplos"><label class="campo">CEP<input name="cep" inputmode="numeric" placeholder="00000-000"></label><label class="campo">Logradouro<input name="logradouro" placeholder="Rua, avenida ou estrada"></label><label class="campo">Número<input name="numero" placeholder="Número"></label><label class="campo">Complemento<input name="complemento" placeholder="Apartamento, bloco ou referência"></label><label class="campo">Bairro<input name="bairro" placeholder="Bairro"></label><label class="campo">País<select name="pais_uuid"><option value="" selected>Selecione</option></select></label><label class="campo">UF<select name="uf_uuid"><option value="" selected>Selecione</option></select></label><label class="campo">Cidade<select name="cidade_uuid"><option value="" selected>Selecione</option></select></label></div></section>
            <section class="card secao-formulario"><h2>Filiação</h2><div class="campos-duplos"><label class="campo">Mãe<input name="mae" placeholder="Nome completo da mãe"></label><label class="campo">Pai<input name="pai" placeholder="Nome completo do pai"></label></div></section>
            <section class="card secao-formulario"><h2>Documentação</h2><div class="campos-duplos"><label class="campo campo--obrigatorio">Tipo de documento<select id="tipo-documento" required><option value="" selected disabled>Selecione</option><option value="cpf">CPF</option><option value="rg">RG</option><option value="cnh">CNH</option><option value="ctps">CTPS</option></select></label><label class="campo campo--obrigatorio">Valor<input id="valor-documento" required placeholder="Selecione o tipo primeiro"></label><label class="campo">Cópia do documento<input type="file" accept="image/*,.pdf"></label></div></section>
            <section class="card secao-formulario"><h2>Dados de acesso ao Argos</h2><div class="campos-duplos"><label class="campo campo--obrigatorio">E-mail<input type="email" required autocomplete="email" placeholder="nome@empresa.com.br"></label><label class="campo">Senha inicial<input readonly value="Será gerada ao salvar"><button class="botao-texto" type="button" disabled>Copiar senha</button></label></div></section>
            <section class="card secao-formulario"><h2>Dados familiares</h2><label class="switch"><input id="casado" type="checkbox"><span class="switch__trilho"><span></span></span><span>É casado?</span></label><div id="dados-conjuge" hidden class="campos-duplos"><label class="campo">Nome do cônjuge<input placeholder="Nome completo"></label><x-campo-data nome="nascimento_conjuge" rotulo="Data de nascimento" /></div><label class="campo">Filhos<input placeholder="Os filhos serão cadastrados após salvar o colaborador" disabled></label></section>
            <section class="card secao-formulario"><h2>Dados de contratação</h2><div class="campos-duplos"><x-campo-data nome="inicio_contrato" rotulo="Data de início" obrigatorio /><label class="campo campo--obrigatorio">Salário<input type="number" min="0" step="0.01" required placeholder="0,00"></label><x-campo-data nome="inicio_ferias" rotulo="Início do período de férias" /><label class="campo">Salário-família<input type="checkbox" disabled><small>Disponível quando houver filho elegível cadastrado.</small></label></div></section>
            <button class="botao-primario" type="submit">Salvar</button>
        </form>
        @else
            <header class="cabecalho-modulo">
                <div><h1>Colaboradores</h1><p>Cadastro e gestão de pessoas</p></div>
                @if ($podeCriar)
                    <a class="botao-primario botao-novo" href="{{ route('colaboradores.index', ['modo' => 'novo']) }}">+ Novo colaborador</a>
                @endif
            </header>
            <section class="filtros"><label class="campo"><span class="sr-only">Buscar colaboradores</span><input type="search" placeholder="Buscar por nome, matrícula ou e-mail"></label><button class="botao-texto" type="button">Limpar filtros</button></section>
            <section class="tabela-colaboradores"><div class="tabela-colaboradores__titulo"><strong>Registros</strong><span>0 colaboradores</span></div><table><thead><tr><th>Matrícula</th><th>Nome</th><th>E-mail</th><th>Ação</th></tr></thead><tbody><tr><td colspan="4"><div class="estado-vazio estado-vazio--tabela"><strong>Nenhum colaborador cadastrado</strong><span>Use “Novo colaborador” para criar o primeiro registro.</span></div></td></tr></tbody></table></section>
        @endif
    </main>
</div>
<script>const casado=document.querySelector('#casado'),conjuge=document.querySelector('#dados-conjuge'),tipo=document.querySelector('#tipo-documento'),valor=document.querySelector('#valor-documento');if(casado){casado.onchange=()=>conjuge.hidden=!casado.checked;tipo.onchange=()=>valor.placeholder={cpf:'000.000.000-00',rg:'Número do RG',cnh:'Número da CNH',ctps:'Número da CTPS'}[tipo.value]}document.querySelectorAll('[data-date-picker]').forEach(c=>c.oninput=()=>{const d=c.value.replace(/\D/g,'').slice(0,8);c.value=d.replace(/(\d{2})(\d)/,'$1/$2').replace(/(\d{2}\/\d{2})(\d)/,'$1/$2')});</script>
</body></html>
