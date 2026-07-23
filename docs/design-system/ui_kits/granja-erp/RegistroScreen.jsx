function RowActions({ record, onView }) {
  const btn = (name, tone, label, onClick) => (
    <button title={label} onClick={onClick} style={{ width: 26, height: 26, display: 'flex', alignItems: 'center', justifyContent: 'center', border: 'none', borderRadius: 'var(--radius-sm)', background: 'transparent', color: tone, cursor: 'pointer', flexShrink: 0 }}
      onMouseEnter={(e) => e.currentTarget.style.background = 'var(--n-100)'}
      onMouseLeave={(e) => e.currentTarget.style.background = 'transparent'}>
      <Icon name={name} size={14} />
    </button>
  );
  return (
    <div style={{ display: 'inline-flex', gap: 0 }}>
      {btn('eye', 'var(--text-secondary)', 'Detalhar', () => onView && onView(record))}
      {btn('edit', 'var(--primary-600)', 'Alterar')}
      {btn('power', 'var(--warning-700)', 'Desativar')}
      {btn('trash', 'var(--danger-500)', 'Excluir')}
    </div>
  );
}

function RegistroScreen({ autoOpenDialog }) {
  const [search, setSearch] = React.useState('');
  const [view, setView] = React.useState('list');
  const [dataEntrada, setDataEntrada] = React.useState('');
  const [viewingRecord, setViewingRecord] = React.useState(null);

  React.useEffect(() => {
    if (autoOpenDialog) setView('form');
  }, [autoOpenDialog]);

  const rows = [
    { lote: 'L-042', galpao: 'Galpão 3', aves: '8.200', postura: '92%', status: <Badge tone="success">Em dia</Badge> },
    { lote: 'L-041', galpao: 'Galpão 1', aves: '7.950', postura: '89%', status: <Badge tone="success">Em dia</Badge> },
    { lote: 'L-039', galpao: 'Galpão 2', aves: '8.600', postura: '85%', status: <Badge tone="warning">Atenção</Badge> },
    { lote: 'L-036', galpao: 'Galpão 1', aves: '7.400', postura: '80%', status: <Badge tone="neutral">Encerrado</Badge> },
  ];

  if (view === 'detail' && viewingRecord) {
    return (
      <div style={{ minHeight: '100%', background: 'var(--bg-page)', fontFamily: 'var(--font-sans)', padding: '32px 40px' }}>
        <div style={{ maxWidth: 1120, margin: '0 auto', display: 'flex', flexDirection: 'column', gap: 20 }}>
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
            <div>
              <div style={{ fontSize: 'var(--text-xl)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>Detalhes do lote</div>
              <div style={{ fontSize: 'var(--text-sm)', color: 'var(--text-secondary)', marginTop: 4 }}>Modo somente leitura</div>
            </div>
            <div style={{ display: 'flex', gap: 12 }}>
              <Button variant="secondary" onClick={() => { setView('list'); setViewingRecord(null); }}>Voltar</Button>
              <Button variant="primary" icon={<Icon name="edit" size={16} />}>Editar</Button>
            </div>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
            <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 24, display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-secondary)', textTransform: 'uppercase', letterSpacing: '0.04em' }}>Identificação</div>
              <Input label="Identificação do lote" value={viewingRecord.lote} disabled />
              <Select label="Galpão" value="x" disabled options={[{ value: 'x', label: viewingRecord.galpao }]} />
              <Select label="Raça / linhagem" value="x" disabled options={[{ value: 'x', label: 'Lohmann Brown' }]} />
            </div>
            <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 24, display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-secondary)', textTransform: 'uppercase', letterSpacing: '0.04em' }}>Plantel</div>
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
                <Input label="Quantidade de aves" value={viewingRecord.aves} unit="aves" disabled />
                <Input label="Postura" value={viewingRecord.postura} disabled />
              </div>
              <Input label="Data de entrada" value="12/01/2026" disabled />
              <div style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
                <span style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-medium)', color: 'var(--text-secondary)' }}>Status</span>
                {viewingRecord.status}
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }

  if (view === 'form') {
    return (
      <div style={{ minHeight: '100%', background: 'var(--bg-page)', fontFamily: 'var(--font-sans)', padding: '32px 40px' }}>
        <div style={{ maxWidth: 1120, margin: '0 auto', display: 'flex', flexDirection: 'column', gap: 20 }}>
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
            <div>
              <div style={{ fontSize: 'var(--text-xl)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>Novo lote</div>
              <div style={{ fontSize: 'var(--text-xs)', color: 'var(--text-muted)', marginTop: 4 }}><span style={{ color: 'var(--danger-500)' }}>*</span> Campos obrigatórios</div>
            </div>
            <div style={{ display: 'flex', gap: 12 }}>
              <Button variant="secondary" onClick={() => setView('list')}>Cancelar</Button>
              <Button variant="primary" onClick={() => setView('list')}>Salvar lote</Button>
            </div>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
            <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 24, display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-secondary)', textTransform: 'uppercase', letterSpacing: '0.04em' }}>Identificação</div>
              <Input label="Identificação do lote" placeholder="Ex: L-043" required />
              <Select label="Galpão" placeholder="Selecione" required options={[{ value: '1', label: 'Galpão 1' }, { value: '2', label: 'Galpão 2' }, { value: '3', label: 'Galpão 3' }]} />
              <Select label="Raça / linhagem" placeholder="Selecione" options={[{ value: 'lohmann', label: 'Lohmann Brown' }, { value: 'hyline', label: 'Hy-Line W-36' }]} />
            </div>
            <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 24, display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-secondary)', textTransform: 'uppercase', letterSpacing: '0.04em' }}>Plantel</div>
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
                <Input label="Quantidade de aves" type="number" placeholder="8000" unit="aves" required />
                <Input label="Peso médio inicial" type="number" placeholder="62" unit="g" />
              </div>
              <Input label="Data de entrada" type="date" value={dataEntrada} onChange={(e) => setDataEntrada(e.target.value)} required />
            </div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div style={{ minHeight: '100%', background: 'var(--bg-page)', fontFamily: 'var(--font-sans)', padding: '32px 40px' }}>
      <div style={{ maxWidth: 1120, margin: '0 auto', display: 'flex', flexDirection: 'column', gap: 20 }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
          <div style={{ fontSize: 'var(--text-xl)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>Lotes</div>
          <Button variant="primary" onClick={() => setView('form')}>+ Novo lote</Button>
        </div>

        <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 16, display: 'flex', gap: 12, alignItems: 'flex-end', flexWrap: 'wrap' }}>
          <div style={{ flex: '1 1 240px', minWidth: 200 }}>
            <Input placeholder="Buscar por identificação do lote" value={search} onChange={(e) => setSearch(e.target.value)} />
          </div>
          <div style={{ width: 180 }}>
            <Select label="Galpão" placeholder="Selecione" options={[{ value: '1', label: 'Galpão 1' }, { value: '2', label: 'Galpão 2' }, { value: '3', label: 'Galpão 3' }]} />
          </div>
          <div style={{ width: 180 }}>
            <Select label="Status" placeholder="Selecione" options={[{ value: 'ativo', label: 'Ativo' }, { value: 'atencao', label: 'Atenção' }, { value: 'encerrado', label: 'Encerrado' }]} />
          </div>
          <Button variant="ghost" size="sm">Limpar filtros</Button>
        </div>

        <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', overflow: 'hidden' }}>
          <Table
            columns={[{ key: 'lote', label: 'Lote' }, { key: 'galpao', label: 'Galpão' }, { key: 'aves', label: 'Aves' }, { key: 'postura', label: 'Postura' }, { key: 'status', label: 'Status' }, { key: 'acoes', label: 'Ação', align: 'center' }]}
            rows={rows.map((r) => ({ ...r, acoes: <RowActions record={r} onView={(rec) => { setViewingRecord(rec); setView('detail'); }} /> }))}
          />
        </div>
      </div>
    </div>
  );
}
