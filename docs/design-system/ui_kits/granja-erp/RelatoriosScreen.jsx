function RelatoriosScreen() {
  const [dataInicio, setDataInicio] = React.useState('01/07/2026');
  const [dataFim, setDataFim] = React.useState('15/07/2026');

  const rows = [
    { data: '15/07/2026', galpao: 'Galpão 1', producao: '8.150', postura: '92%', consumo: '1.020 kg', mortalidade: '0.3%' },
    { data: '15/07/2026', galpao: 'Galpão 2', producao: '7.320', postura: '85%', consumo: '980 kg', mortalidade: '0.6%' },
    { data: '15/07/2026', galpao: 'Galpão 3', producao: '8.010', postura: '91%', consumo: '1.050 kg', mortalidade: '0.4%' },
    { data: '14/07/2026', galpao: 'Galpão 1', producao: '8.080', postura: '91%', consumo: '1.015 kg', mortalidade: '0.4%' },
    { data: '14/07/2026', galpao: 'Galpão 2', producao: '7.290', postura: '84%', consumo: '975 kg', mortalidade: '0.5%' },
  ];

  return (
    <div style={{ minHeight: '100%', background: 'var(--bg-page)', fontFamily: 'var(--font-sans)', padding: '32px 40px' }}>
      <div style={{ maxWidth: 1160, margin: '0 auto', display: 'flex', flexDirection: 'column', gap: 20 }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
          <div>
            <div style={{ fontSize: 'var(--text-xl)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>Relatórios</div>
            <div style={{ fontSize: 'var(--text-sm)', color: 'var(--text-secondary)' }}>Produção diária por galpão</div>
          </div>
          <div style={{ display: 'flex', gap: 12 }}>
            <Button variant="secondary" icon={<Icon name="box" size={16} />}>Exportar CSV</Button>
            <Button variant="secondary" icon={<Icon name="file" size={16} />}>Exportar PDF</Button>
          </div>
        </div>

        <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 16, display: 'flex', gap: 12, alignItems: 'flex-end', flexWrap: 'wrap' }}>
          <div style={{ width: 160 }}>
            <Input label="De" type="date" value={dataInicio} onChange={(e) => setDataInicio(e.target.value)} />
          </div>
          <div style={{ width: 160 }}>
            <Input label="Até" type="date" value={dataFim} onChange={(e) => setDataFim(e.target.value)} />
          </div>
          <div style={{ width: 180 }}>
            <Select label="Galpão" placeholder="Selecione" options={[{ value: '1', label: 'Galpão 1' }, { value: '2', label: 'Galpão 2' }, { value: '3', label: 'Galpão 3' }]} />
          </div>
          <div style={{ width: 200 }}>
            <Select label="Indicador" placeholder="Selecione" options={[{ value: 'producao', label: 'Produção' }, { value: 'postura', label: 'Postura' }, { value: 'consumo', label: 'Consumo de ração' }, { value: 'mortalidade', label: 'Mortalidade' }]} />
          </div>
          <Button variant="ghost" size="sm">Limpar filtros</Button>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))', gap: 16 }}>
          <StatCard label="Produção no período" value="235.4k" unit="ovos" delta="+2.1%" icon={<Icon name="egg" size={18} />} />
          <StatCard label="Postura média" value="88.6" unit="%" delta="+0.4%" icon={<Icon name="chart" size={18} />} />
          <StatCard label="Consumo de ração" value="21.3k" unit="kg" delta="-0.8%" icon={<Icon name="feed" size={18} />} />
          <StatCard label="Mortalidade média" value="0.44" unit="%" delta="-0.1%" icon={<Icon name="alert" size={18} />} />
        </div>

        <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 20 }}>
          <div style={{ fontSize: 'var(--text-base)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-primary)', marginBottom: 12 }}>Produção diária</div>
          <div style={{ height: 200, borderRadius: 8, background: 'repeating-linear-gradient(90deg, var(--n-100), var(--n-100) 10px, var(--bg-surface) 10px, var(--bg-surface) 20px)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <span style={{ fontFamily: 'monospace', fontSize: 12, color: 'var(--text-muted)' }}>gráfico de linha — produção diária no período</span>
          </div>
        </div>

        <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', overflow: 'hidden' }}>
          <div style={{ padding: '16px 20px', fontSize: 'var(--text-base)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-primary)', borderBottom: '1px solid var(--border-subtle)' }}>Detalhamento por galpão</div>
          <Table
            columns={[{ key: 'data', label: 'Data' }, { key: 'galpao', label: 'Galpão' }, { key: 'producao', label: 'Produção' }, { key: 'postura', label: 'Postura' }, { key: 'consumo', label: 'Consumo' }, { key: 'mortalidade', label: 'Mortalidade' }]}
            rows={rows}
          />
        </div>
      </div>
    </div>
  );
}
