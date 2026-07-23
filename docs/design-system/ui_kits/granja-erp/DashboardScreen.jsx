const navItems = [
  { id: 'dashboard', icon: <Icon name="dashboard" />, label: 'Painel' },
  { id: 'producao', icon: <Icon name="egg" />, label: 'Produção' },
  { id: 'manejo', icon: <Icon name="animal" />, label: 'Manejo animal' },
  { id: 'alimentacao', icon: <Icon name="feed" />, label: 'Alimentação' },
  { id: 'estoque', icon: <Icon name="box" />, label: 'Estoque', badge: 3 },
  { id: 'compras', icon: <Icon name="cart" />, label: 'Compras' },
  { id: 'comercial', icon: <Icon name="truck" />, label: 'Comercial' },
  { id: 'financeiro', icon: <Icon name="dollar" />, label: 'Financeiro' },
  { id: 'patrimonio', icon: <Icon name="wrench" />, label: 'Patrimônio' },
  { id: 'rh', icon: <Icon name="users" />, label: 'Equipe' },
  { id: 'relatorios', icon: <Icon name="chart" />, label: 'Relatórios' },
];

function DashboardScreen({ onNovoLote }) {
  return (
    <div style={{ minHeight: '100%', fontFamily: 'var(--font-sans)', background: 'var(--bg-page)' }}>
      <div style={{ padding: 32, display: 'flex', flexDirection: 'column', gap: 24 }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
          <div>
            <div style={{ fontSize: 'var(--text-xl)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>Painel geral</div>
            <div style={{ fontSize: 'var(--text-sm)', color: 'var(--text-secondary)' }}>Terça-feira, 15 de julho</div>
          </div>
          <Button variant="primary" onClick={onNovoLote}>+ Novo lote</Button>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))', gap: 16 }}>
          <StatCard label="Produção do dia" value="12.480" unit="ovos" delta="+3.2%" icon={<Icon name="egg" size={18} />} />
          <StatCard label="Postura" value="91.4" unit="%" delta="+0.6%" icon={<Icon name="chart" size={18} />} />
          <StatCard label="Consumo de ração" value="4.120" unit="kg" delta="-1.1%" icon={<Icon name="feed" size={18} />} />
          <StatCard label="Mortalidade" value="0.8" unit="%" delta="-0.1%" icon={<Icon name="alert" size={18} />} />
          <StatCard label="Faturamento" value="R$ 38.2k" delta="+5.4%" icon={<Icon name="dollar" size={18} />} />
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: 16 }}>
          <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 20 }}>
            <div style={{ fontSize: 'var(--text-base)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-primary)', marginBottom: 12 }}>Produção por galpão — última semana</div>
            <LineChart
              days={['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom']}
              series={[
                { label: 'Galpão 1', color: 'var(--primary-500)', values: [7820, 7890, 7910, 7950, 7900, 7960, 7950] },
                { label: 'Galpão 2', color: 'var(--accent-500)', values: [7180, 7230, 7260, 7300, 7290, 7310, 7320] },
                { label: 'Galpão 3', color: 'var(--warning-500)', values: [8050, 8090, 8120, 8150, 8180, 8190, 8200] },
              ]}
            />
          </div>
          <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 20 }}>
            <div style={{ fontSize: 'var(--text-base)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-primary)', marginBottom: 12 }}>Alertas</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 10 }}>
              <AlertItem level="critico" message="3 pedidos atrasados" />
              <AlertItem level="atencao" message="Estoque de ração baixo" />
              <AlertItem level="aviso" message="Vacinação pendente — Lote L-039" />
            </div>
          </div>
        </div>

        <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 20 }}>
          <div style={{ fontSize: 'var(--text-base)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-primary)', marginBottom: 12 }}>Lotes ativos</div>
          <Table
            columns={[{ key: 'lote', label: 'Lote' }, { key: 'galpao', label: 'Galpão' }, { key: 'aves', label: 'Aves' }, { key: 'postura', label: 'Postura' }, { key: 'status', label: 'Status' }]}
            rows={[
              { lote: 'L-042', galpao: 'Galpão 3', aves: '8.200', postura: '92%', status: <Badge tone="success">Em dia</Badge> },
              { lote: 'L-041', galpao: 'Galpão 1', aves: '7.950', postura: '89%', status: <Badge tone="success">Em dia</Badge> },
              { lote: 'L-039', galpao: 'Galpão 2', aves: '8.600', postura: '85%', status: <Badge tone="warning">Atenção</Badge> },
            ]}
          />
        </div>
      </div>
    </div>
  );
}
