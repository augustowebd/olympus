function EquipesScreen() {
  const [tab, setTab] = React.useState('ativos');
  const [view, setView] = React.useState('list');
  const [search, setSearch] = React.useState('');
  const [toast, setToast] = React.useState(null);
  const [confirmDelete, setConfirmDelete] = React.useState(null);
  const [notifica, setNotifica] = React.useState(true);
  const [ativoImediato, setAtivoImediato] = React.useState(true);
  const [dataAdmissao, setDataAdmissao] = React.useState('');
  const [salario, setSalario] = React.useState('');
  const [viewingRecord, setViewingRecord] = React.useState(null);

  const ativos = [
    { nome: 'Maria Souza', cargo: 'Encarregada de galpão', turno: 'Manhã', status: <Badge tone="success">Ativo</Badge> },
    { nome: 'João Pereira', cargo: 'Auxiliar de produção', turno: 'Tarde', status: <Badge tone="success">Ativo</Badge> },
    { nome: 'Ana Lima', cargo: 'Técnica avícola', turno: 'Manhã', status: <Badge tone="warning">Férias</Badge> },
  ];
  const inativos = [
    { nome: 'Carlos Dias', cargo: 'Auxiliar de estoque', turno: 'Tarde', status: <Badge tone="neutral">Inativo</Badge> },
  ];
  const rows = tab === 'ativos' ? ativos : inativos;

  React.useEffect(() => {
    if (!toast) return;
    const t = setTimeout(() => setToast(null), 2600);
    return () => clearTimeout(t);
  }, [toast]);

  function RowActions({ record }) {
    const btn = (name, tone, label, onClick) => (
      <button title={label} onClick={onClick} style={{ width: 26, height: 26, display: 'flex', alignItems: 'center', justifyContent: 'center', border: 'none', borderRadius: 'var(--radius-sm)', background: 'transparent', color: tone, cursor: 'pointer', flexShrink: 0 }}
        onMouseEnter={(e) => e.currentTarget.style.background = 'var(--n-100)'}
        onMouseLeave={(e) => e.currentTarget.style.background = 'transparent'}>
        <Icon name={name} size={14} />
      </button>
    );
    return (
      <div style={{ display: 'inline-flex', gap: 0 }}>
        {btn('eye', 'var(--text-secondary)', 'Detalhar', () => { setViewingRecord(record); setView('detail'); })}
        {btn('edit', 'var(--primary-600)', 'Alterar')}
        {btn('power', 'var(--warning-700)', 'Desativar')}
        {btn('trash', 'var(--danger-500)', 'Excluir', () => setConfirmDelete(record.nome))}
      </div>
    );
  }

  if (view === 'detail' && viewingRecord) {
    const statusLabel = viewingRecord.status && viewingRecord.status.props ? viewingRecord.status.props.children : '—';
    return (
      <div style={{ minHeight: '100%', background: 'var(--bg-page)', fontFamily: 'var(--font-sans)', padding: '32px 40px' }}>
        <div style={{ maxWidth: 1120, margin: '0 auto', display: 'flex', flexDirection: 'column', gap: 20 }}>
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
            <div>
              <div style={{ fontSize: 'var(--text-xl)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>Detalhes do funcionário</div>
              <div style={{ fontSize: 'var(--text-sm)', color: 'var(--text-secondary)', marginTop: 4 }}>Modo somente leitura</div>
            </div>
            <div style={{ display: 'flex', gap: 12 }}>
              <Button variant="secondary" onClick={() => { setView('list'); setViewingRecord(null); }}>Voltar</Button>
              <Button variant="primary" icon={<Icon name="edit" size={16} />}>Editar</Button>
            </div>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
            <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 24, display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-secondary)', textTransform: 'uppercase', letterSpacing: '0.04em' }}>Dados pessoais</div>
              <Input label="Nome completo" value={viewingRecord.nome} disabled />
              <Input label="Telefone" value="(64) 99123-4567" disabled />
              <Select label="Cargo" value="x" disabled options={[{ value: 'x', label: viewingRecord.cargo }]} />
            </div>
            <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 24, display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-secondary)', textTransform: 'uppercase', letterSpacing: '0.04em' }}>Vínculo</div>
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
                <Select label="Turno" value="x" disabled options={[{ value: 'x', label: viewingRecord.turno }]} />
                <Input label="Data de admissão" value="10/03/2024" disabled />
              </div>
              <Input label="Salário" type="currency" value="2.400,00" disabled />
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
              <div style={{ fontSize: 'var(--text-xl)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>Novo funcionário</div>
              <div style={{ fontSize: 'var(--text-xs)', color: 'var(--text-muted)', marginTop: 4 }}><span style={{ color: 'var(--danger-500)' }}>*</span> Campos obrigatórios</div>
            </div>
            <div style={{ display: 'flex', gap: 12 }}>
              <Button variant="secondary" onClick={() => setView('list')}>Cancelar</Button>
              <Button variant="primary" onClick={() => { setView('list'); setToast('Funcionário salvo com sucesso'); }}>Salvar funcionário</Button>
            </div>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
            <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 24, display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-secondary)', textTransform: 'uppercase', letterSpacing: '0.04em' }}>Dados pessoais</div>
              <Input label="Nome completo" placeholder="Ex: Maria Souza" required />
              <Input label="Telefone" placeholder="(00) 00000-0000" />
              <Select label="Cargo" placeholder="Selecione" required options={[{ value: 'encarregado', label: 'Encarregado de galpão' }, { value: 'auxiliar', label: 'Auxiliar de produção' }, { value: 'tecnico', label: 'Técnico avícola' }]} />
            </div>
            <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 24, display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-semibold)', color: 'var(--text-secondary)', textTransform: 'uppercase', letterSpacing: '0.04em' }}>Vínculo</div>
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
                <Select label="Turno" placeholder="Selecione" required options={[{ value: 'manha', label: 'Manhã' }, { value: 'tarde', label: 'Tarde' }, { value: 'integral', label: 'Integral' }]} />
                <Input label="Data de admissão" type="date" value={dataAdmissao} onChange={(e) => setDataAdmissao(e.target.value)} required />
              </div>
              <Input label="Salário" type="currency" value={salario} onChange={(e) => setSalario(e.target.value)} />
              <Checkbox label="Ativo imediatamente" checked={ativoImediato} onChange={() => setAtivoImediato(!ativoImediato)} />
              <Switch label="Receber notificações de escala" checked={notifica} onChange={setNotifica} />
            </div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div style={{ minHeight: '100%', background: 'var(--bg-page)', fontFamily: 'var(--font-sans)', padding: '32px 40px', position: 'relative' }}>
      <div style={{ maxWidth: 1120, margin: '0 auto', display: 'flex', flexDirection: 'column', gap: 20 }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
          <div style={{ fontSize: 'var(--text-xl)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>Equipes</div>
          <Button variant="primary" onClick={() => setView('form')}>+ Novo funcionário</Button>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))', gap: 16 }}>
          <StatCard label="Funcionários ativos" value="3" icon={<Icon name="users" size={18} />} />
          <StatCard label="Escalas hoje" value="2" icon={<Icon name="dashboard" size={18} />} />
          <StatCard label="Tarefas pendentes" value="5" delta="-2" icon={<Icon name="chart" size={18} />} />
        </div>

        <Tabs tabs={[{ id: 'ativos', label: `Ativos (${ativos.length})` }, { id: 'inativos', label: `Inativos (${inativos.length})` }]} activeId={tab} onChange={setTab} />

        <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', padding: 16, display: 'flex', gap: 12, alignItems: 'flex-end', flexWrap: 'wrap' }}>
          <div style={{ flex: '1 1 240px', minWidth: 200 }}>
            <Input placeholder="Buscar por nome" value={search} onChange={(e) => setSearch(e.target.value)} />
          </div>
          <div style={{ width: 200 }}>
            <Select label="Cargo" placeholder="Selecione" options={[{ value: 'encarregado', label: 'Encarregado de galpão' }, { value: 'auxiliar', label: 'Auxiliar de produção' }, { value: 'tecnico', label: 'Técnico avícola' }]} />
          </div>
          <Button variant="ghost" size="sm">Limpar filtros</Button>
        </div>

        <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', overflow: 'hidden' }}>
          <Table
            columns={[{ key: 'nome', label: 'Nome' }, { key: 'cargo', label: 'Cargo' }, { key: 'turno', label: 'Turno' }, { key: 'status', label: 'Status' }, { key: 'acoes', label: 'Ação', align: 'center' }]}
            rows={rows.map((r) => ({ ...r, acoes: <RowActions record={r} /> }))}
          />
        </div>
      </div>

      {toast && (
        <div style={{ position: 'fixed', bottom: 24, right: 24, zIndex: 50 }}>
          <Toast tone="success" message={toast} onClose={() => setToast(null)} />
        </div>
      )}

      <Dialog
        open={!!confirmDelete}
        title="Excluir funcionário?"
        onClose={() => setConfirmDelete(null)}
        actions={<React.Fragment>
          <Button variant="secondary" onClick={() => setConfirmDelete(null)}>Cancelar</Button>
          <Button variant="danger" onClick={() => { setConfirmDelete(null); setToast('Funcionário removido'); }}>Excluir</Button>
        </React.Fragment>}
      >
        Esta ação não pode ser desfeita. {confirmDelete} será removido permanentemente da equipe.
      </Dialog>
    </div>
  );
}
