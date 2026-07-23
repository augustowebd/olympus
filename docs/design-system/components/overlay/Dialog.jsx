import React from 'react';

export function Dialog({ open, title, children, onClose, actions, width = 420 }) {
  if (!open) return null;
  return (
    <div style={{ position: 'fixed', inset: 0, background: 'oklch(20% 0.02 250 / 0.4)', display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 100 }}>
      <div style={{ background: 'var(--bg-surface)', borderRadius: 'var(--radius-lg)', boxShadow: 'var(--shadow-lg)', padding: 'var(--space-6)', width, maxWidth: '90vw', fontFamily: 'var(--font-sans)' }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 16 }}>
          <h2 style={{ margin: 0, fontSize: 'var(--text-lg)', fontWeight: 'var(--weight-bold)', color: 'var(--text-primary)' }}>{title}</h2>
          <button onClick={onClose} style={{ border: 'none', background: 'none', fontSize: 'var(--text-lg)', cursor: 'pointer', color: 'var(--text-muted)' }}>×</button>
        </div>
        <div style={{ color: 'var(--text-secondary)', fontSize: 'var(--text-base)', lineHeight: 'var(--leading-normal)' }}>{children}</div>
        {actions && <div style={{ display: 'flex', gap: 12, justifyContent: 'flex-end', marginTop: 24 }}>{actions}</div>}
      </div>
    </div>
  );
}
