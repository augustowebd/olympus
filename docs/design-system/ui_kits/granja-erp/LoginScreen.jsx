
function LoginScreen() {
  return (
    <div style={{ minHeight: '100%', display: 'flex', background: 'var(--bg-page)', fontFamily: 'var(--font-sans)' }}>
      <div style={{ flex: 1, display: 'flex', alignItems: 'center', justifyContent: 'center', padding: 40 }}>
        <div style={{ width: '100%', maxWidth: 380, display: 'flex', flexDirection: 'column', gap: 24 }}>
          <div>
            <div style={{ fontSize: 'var(--text-2xl)', fontWeight: 'var(--weight-extrabold)', color: 'var(--primary-700)' }}>Granja ERP</div>
            <div style={{ fontSize: 'var(--text-base)', color: 'var(--text-secondary)', marginTop: 6 }}>Entre para acompanhar sua granja</div>
          </div>
          <Input label="Usuário" placeholder="seu.usuario" required />
          <Input label="Senha" type="password" placeholder="••••••••" required />
          <Button variant="primary" fullWidth size="md">Entrar</Button>
          <a href="#" style={{ textAlign: 'center', fontSize: 'var(--text-sm)', color: 'var(--text-link)' }}>Esqueci minha senha</a>
        </div>
      </div>
      <div style={{ flex: 1, background: 'repeating-linear-gradient(135deg, var(--primary-100), var(--primary-100) 12px, var(--primary-50) 12px, var(--primary-50) 24px)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
        <span style={{ fontFamily: 'monospace', fontSize: 13, color: 'var(--primary-700)', background: 'var(--bg-surface)', padding: '6px 14px', borderRadius: 8 }}>foto da granja / galpões</span>
      </div>
    </div>
  );
}
